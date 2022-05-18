<?php

namespace App\Http\Controllers;

use App\Models\OfferType;
use Illuminate\Http\Request;

class OfferTypeController extends Controller
{
    public function index()
    {
        return view('offer_types.index', ['offer_types' => OfferType::paginate(10)]);
    }
    public function show(OfferType $offerType)
    {
        return view('offer_types.view', ['offer_type' => $offerType]);
    }
    public function edit(OfferType $offerType)
    {
        return view('offer_types.edit', ['offer_type' => $offerType]);
    }
    public function update(Request $request, OfferType $offerType)
    {
        $request['status'] = isset($request->status) ? 1 : 0;
        $request->validate([
            'name_en' => 'required|min:3',
            'name_pt' => 'required|min:3',
            'name_ar' => 'required|min:3',
            'price' => 'numeric|required|min:1',
            'description' => 'required|min:20',
        ]);
        $offerType->update($request->all());
        return redirect('offer_types');
    }
    public function changeStatus(OfferType $offerType)
    {
        $offerType->status = $offerType->status ? 0 : 1;
        $offerType->update();
        return redirect('/offer_types');
    }
}
