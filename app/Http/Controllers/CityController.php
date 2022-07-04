<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::paginate(10);
        return view('cities.index', ['cities' => $cities]);
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(CityRequest $request)
    {
        City::create($request->validated());
        return redirect('/cities');
    }

    public function show(City $city)
    {
        return view('cities.view', ['city' => $city]);
    }

    public function edit(City $city)
    {
        return view('cities.edit', ['city' => $city]);
    }

    public function update(CityRequest $request, City $city)
    {
        $city->update($request->validated());
        return redirect('cities');
    }

    public function destroy(City $city)
    {
        if (!json_decode($city->offers))
            $city->delete();
        return redirect('cities');
    }

    public function search(Request $request)
    {
        $cities = City::where('name_en', 'Like', '%' . $request->name_en . '%')->paginate(10);
        return view('cities.index', ['cities' => $cities]);
    }

    public function changeStatus(City $city)
    {
        $city->update(['status' => !$city->status]);
        return back();
    }
}
