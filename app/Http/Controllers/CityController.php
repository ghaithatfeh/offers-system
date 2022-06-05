<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => ['required', 'min:3'],
            'name_pt' => ['required', 'min:3'],
            'name_ar' => ['required', 'min:3'],
        ]);
        City::create($request->all());
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

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name_en' => ['required', 'min:3'],
            'name_pt' => ['required', 'min:3'],
            'name_ar' => ['required', 'min:3'],
        ]);
        $city->update($request->all());
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
        $cities = City::where('name_en', 'Like', '%' . $request->name_en . '%')->paginate(3);
        return view('cities.index', ['cities' => $cities]);
    }

    public function changeStatus(City $city)
    {
        $city->status = $city->status ? 0 : 1;
        $city->update();
        return redirect('/cities');
    }
}
