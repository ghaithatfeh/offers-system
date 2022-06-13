<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderByDesc('id')->paginate(10);
        return view('customers.index', ['customers' => $customers]);
    }

    public function show(Customer $customer)
    {
        return view('customers.view', ['customer' => $customer]);
    }

    public function changeStatus(Customer $customer)
    {
        $customer->update(['status' => !$customer->status]);
        return back();
    }
}
