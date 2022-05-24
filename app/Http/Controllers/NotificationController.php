<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Notification;
use App\Models\NotificationReceiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        if ($request->target_value)
            $request['target_value'] = implode("|", $request->target_value);
        $notification = Notification::create($request->all());
        $this->notificationReciever($notification);

        return redirect('/notifications');
    }

    public function notificationReciever($notification)
    {
        switch ($notification->target_type) {
            case 'Cities':
                $customers_ids = DB::table('customers')
                    ->select(['id'])
                    ->whereIn('city_id', explode('|', $notification->target_value))
                    ->get()
                    ->pluck('id')
                    ->toArray();
                break;
            case 'Categories':
                $customers_ids = DB::table('customers_interests')
                    ->select(['customer_id'])
                    ->whereIn('category_id', explode('|', $notification->target_value))
                    ->distinct()
                    ->get()
                    ->pluck('id')
                    ->toArray();;
                break;
            case 'Gender':
                $customers_ids = DB::table('customers')
                    ->select(['id'])
                    ->whereIn('gender', explode('|', $notification->target_value))
                    ->get()
                    ->pluck('id')
                    ->toArray();;
                break;
        }
        $data = [];
        foreach ($customers_ids as $id) {
            $data[] = ['customer_id' => $id, 'notification_id' => $notification->id];
        }
        NotificationReceiver::insert($data);
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
        $target_value = explode('|', $notification->target_value);

        if ($notification->target_type == 'Cities')
            $target_value = City::select('name_en')
                ->find($target_value)
                ->pluck('name_en')
                ->toArray();

        elseif ($notification->target_type == 'Categories')
            $target_value = Category::select('name_en')
                ->find($target_value)
                ->pluck('name_en')
                ->toArray();

        $notification->target_value = implode(', ', $target_value);

        return view('notifications.view', ['notification' => $notification]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect('/notifications');
    }
}
