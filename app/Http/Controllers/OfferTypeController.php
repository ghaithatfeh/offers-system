<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferTypeRequest;
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
    
    public function update(OfferTypeRequest $request, OfferType $offerType)
    {
        $offerType->update($request->validated());
        return redirect('offer_types');
    }
}
