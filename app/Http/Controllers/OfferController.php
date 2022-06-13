<?php

namespace App\Http\Controllers;

use App\Imports\OffersImport;
use App\Models\Category;
use App\Models\City;
use App\Models\Image;
use App\Models\Offer;
use App\Models\OfferTag;
use App\Models\OfferType;
use App\Models\Tag;
use App\Models\TargetArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role != 'Store Owner')
            $offers = Offer::orderByDesc('id')->paginate(10);
        else
            $offers = Offer::where('user_id', '=', auth()->id())->orderByDesc('id')->paginate(10);

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
            'description' => 'min:20',
            'images.*' => 'image',
        ]);
        if (auth()->user()->role == 'Store Owner')
            $request['offer_type_id'] = 1;

        $request['user_id'] = auth()->id();
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
            if (!file_exists(public_path('uploaded_images'))) {
                mkdir(public_path('uploaded_images'), 0777, true);
            }
            $files = $request->file('images');
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploaded_images', $fileName);
                Image::create([
                    'name' => $fileName,
                    'offer_id' => $offer->id
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
        if ($offer->user_id != auth()->id())
            return abort('403');

        return view('offers.edit', [
            'offer' => $offer,
            'offer_types' => OfferType::all(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'cities' => City::all(),
        ]);
    }

    public function update(Request $request, Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort('403');
        $request->validate([
            'title' => 'required',
            'expiry_date' => 'after:yesterday',
            'price' => 'numeric|min:1',
            'category_id' => 'required',
            'offer_type_id' => 'required',
            'description' => 'min:20',
        ]);
        $offer->update($request->all());
        OfferTag::destroy($offer->id);
        TargetArea::destroy($offer->id);

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

        return redirect('/offers');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort('403');

        if (json_decode($offer->images))
            foreach ($offer->images as $image)
                if (file_exists(public_path('uploaded_images/' . $image->name)))
                    unlink(public_path('uploaded_images/' . $image->name));
        $offer->delete();
        return back();
    }

    public function review(Offer $offer, Request $request)
    {
        if ($request->result == 'reject' && $offer->status != 'Rejected') {
            $offer->status = 'Rejected';
            $offer->reject_reason = $request->reason;
        } elseif ($request->result == 'approve' && $offer->status == 'On Hold') {
            $offer->status = 'Approved';
            $offer->reject_reason = '';
        }
        $offer->reviewed_at = Carbon::now();
        $offer->reviewed_by = auth()->id();
        $offer->timestamps = false;
        $offer->update();
        dd($offer->reviewed_by);
        return redirect()->back();
    }

    public function upload(Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort(403);
        return view('offers.images_upload', ['offer' => $offer]);
    }

    public function upload_store(Request $request, Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort(403);
        $request->validate([
            'images' => 'required',
            'images.*' => 'image'
        ]);
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploaded_images'), $image_name);
                Image::create([
                    'name' => $image_name,
                    'offer_id' => $offer->id
                ]);
            }
        }
        return back();
    }

    public function delete_image(Image $image)
    {
        if ($image->offer->user_id != auth()->id())
            return abort(403);
        if (file_exists(public_path('uploaded_images/' . $image->name)))
            unlink(public_path('uploaded_images/' . $image->name));
        $image->delete();
        return back();
    }
}
