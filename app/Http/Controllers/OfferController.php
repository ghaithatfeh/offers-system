<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Image;
use App\Models\Offer;
use App\Models\OfferTag;
use App\Models\OfferType;
use App\Models\Tag;
use App\Models\TargetArea;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::paginate(10);
        return view('offers.index', [
            'offers' => $offers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offers.create', [
            'offer_types' => OfferType::all(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = 1;
        $offer = Offer::create($request->all());

        $offerTags = [];
        foreach ($request->tags as $tag) {
            $offerTags[] = ['offer_id' => $offer->id, 'tag_id' => $tag];
        }
        OfferTag::insert($offerTags);

        $offerCities = [];
        foreach ($request->cities as $city) {
            $offerCities[] = ['offer_id' => $offer->id, 'city_id' => $city];
        }
        TargetArea::insert($offerCities);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploaded_images', $fileName);
                Image::create([
                    'name' => $fileName,
                    'offer_id' => $offer->id,
                ]);
            }
        }

        return redirect('/offers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return view('offers.view', ['offer' => $offer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
