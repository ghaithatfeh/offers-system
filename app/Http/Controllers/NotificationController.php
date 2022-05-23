<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::paginate(10);
        return view('notifications.index', ['notifications' => $notifications]);
    }

    public function create()
    {
        return view('notifications.create', []);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:50'
        ]);
        $request['target_value'] = implode("|", $request->target_value);
        Notification::create($request->all());
        return redirect('/notifications');
    }

    public function getOptions(Request $request)
    {
        if ($request->type == 'Categories') {
            $resulte = Category::select(['id', 'name_en as text'])->get();
        } elseif ($request->type == 'Cities') {
            $resulte = City::select(['id', 'name_en as text'])->get();
        }
        return $resulte;
    }

    public function show(Notification $notification)
    {
        return view('notifications.view', ['notification' => $notification]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect('/notifications');
    }
}
