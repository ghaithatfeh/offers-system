<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Notification;
use App\Models\NotificationReceiver;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderByDesc('id')->paginate(10);
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
            'body' => 'required|min:50',
            'target_type' => 'required',
            // 'target_value' => 'required_if:target_type,Broadcast'
            'target_value' => Rule::requiredIf($request->target_type != 'Broadcast')
        ]);
        if ($request->target_value)
            $request['target_value'] = implode("|", $request->target_value);
        $notification = Notification::create($request->all());
        if (!$this->notificationReciever($notification)) {
            $notification->delete();
            $request->session()->flash('notify-message', __('An error occurred, the notification was not sent.'));
            $request->session()->flash('notify-alert', 'alert-danger');
        } else {
            $request->session()->flash('notify-message', __('The notification has been sent successfully.'));
            $request->session()->flash('notify-alert', 'alert-success');
        }


        return redirect('/notifications');
    }

    public function notificationReciever($notification)
    {
        $target_value = explode('|', $notification->target_value);

        switch ($notification->target_type) {
            case 'Cities':
                $customers_ids = DB::table('customers')
                    ->select(['id'])
                    ->whereIn('city_id', $target_value)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                break;
            case 'Categories':
                $customers_ids = DB::table('customers_interests')
                    ->select(['customer_id'])
                    ->whereIn('category_id', $target_value)
                    ->distinct()
                    ->get()
                    ->pluck('customer_id')
                    ->toArray();
                break;
            case 'Gender':
                $customers_ids = DB::table('customers')
                    ->select(['id'])
                    ->whereIn('gender', $target_value)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                break;
            case 'Broadcast':
                $customers_ids = DB::table('customers')
                    ->select(['id'])
                    ->get()
                    ->pluck('id')
                    ->toArray();
        }
        if (isset($customers_ids[0])) {
            $data = [];
            foreach ($customers_ids as $id) {
                $data[] = ['customer_id' => $id, 'notification_id' => $notification->id];
            }
            NotificationReceiver::insert($data);
            return true;
        }
        return false;
    }

    public function getOptions(Request $request)
    {
        if ($request->type == 'Categories') {
            $resulte = Category::select(['id', 'name_en as text'])->where('status', 1)->get();
        } elseif ($request->type == 'Cities') {
            $resulte = City::select(['id', 'name_en as text'])->where('status', 1)->get();
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

        $notification->target_value = implode('<br>', $target_value);

        return view('notifications.view', ['notification' => $notification]);
    }
}
