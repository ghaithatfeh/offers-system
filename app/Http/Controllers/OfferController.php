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
    public function index()
    {
        $offers = Offer::paginate(10);
        return view('offers.index', [
            'offers' => $offers,
        ]);
    }

    public function create()
    {
        return view('offers.create', [
            'offer_types' => OfferType::all(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'cities' => City::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'expiry_date' => 'after:yesterday',
            'price' => 'numeric|min:1',
            'category_id' => 'required',
            'offer_type_id' => 'required',
            'description' => 'min:50',
            // 'images' => 'mimes:jpg,jpeg,png'
        ]);
        $request['user_id'] = 1;
        $offer = Offer::create($request->all());

        if ($request->tags) {
            $offerTags = [];
            foreach ($request->tags as $tag) {
                $offerTags[] = ['offer_id' => $offer->id, 'tag_id' => $tag];
            }
            OfferTag::insert($offerTags);
        }

        if ($request->cities) {
            $offerCities = [];
            foreach ($request->cities as $city) {
                $offerCities[] = ['offer_id' => $offer->id, 'city_id' => $city];
            }
            TargetArea::insert($offerCities);
        }

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

    public function show(Offer $offer)
    {
        return view('offers.view', ['offer' => $offer]);
    }

    public function edit(Offer $offer)
    {
        //
    }

    public function update(Request $request, Offer $offer)
    {
        //
    }

    public function destroy(Offer $offer)
    {
        if (json_decode($offer->images))
            foreach ($offer->images as $image)
                if (file_exists(public_path('uploaded_images/' . $image->name)))
                    unlink(public_path('uploaded_images/' . $image->name));
        $offer->delete();
        return redirect('/offers');
    }
}
