<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderByDesc('id')->paginate(10);
        return view('customers.index', ['customers' => $customers]);
    }

    public function show(Customer $customer)
    {
        $interested_categories = Category::select('name_' . App::getLocale() . ' AS name')
            ->join('customers_interests', 'category_id', 'categories.id')
            ->where('customers_interests.customer_id', $customer->id)
            ->get();
        return view('customers.view', [
            'customer' => $customer,
            'interested_categories' => $interested_categories
        ]);
    }

    public function changeStatus(Customer $customer)
    {
        $customer->status = !$customer->status;
        $customer->update();
        return back();
    }
}
