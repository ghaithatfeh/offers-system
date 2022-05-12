<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(3);
        return view('cities.index', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        $request->validate([
            'name_en' => ['required', 'min:3'],
        ]);

        City::create($request->all());

        return redirect('/cities');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return view('cities.view', ['city' => $city]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('cities.edit', ['city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        $city->update($request->all());
        return redirect('cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
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
