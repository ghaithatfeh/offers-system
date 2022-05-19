<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(){
        $stores = Store::paginate(10);
        return view('stores.index', [
            'stores' => $stores,
        ]);
    }

    public function create(){
        $cities = City::all();
        return view('stores.create', ['cities' => $cities]);
    }
}
