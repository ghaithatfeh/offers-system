<?php

namespace App\Http\Controllers;

use App\Models\OfferType;
use Illuminate\Http\Request;

class OfferTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('offer_types.index', ['offer_types' => OfferType::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer_types.create');
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
        OfferType::create($request->all());
        return redirect('/offer_types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function show(OfferType $offerType)
    {
        return view('offer_types.view', ['offer_type' => $offerType]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferType $offerType)
    {
        return view('offer_types.edit', ['offer_type' => $offerType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferType $offerType)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        $offerType->update($request->all());
        return redirect('offer_types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferType $offerType)
    {
        $offerType->delete();
        return redirect('/offer_types');
    }

    public function changeStatus(OfferType $offerType)
    {
        $offerType->status = $offerType->status ? 0 : 1;
        $offerType->update();
        return redirect('/offer_types');
    }
}
