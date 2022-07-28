<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = Offer::with('user.store')->when(auth()->user()->role == 'Store Owner', function ($offers) {
            $offers->where('user_id', '=', auth()->id());
        })->orderByDesc('id')->paginate(10);

        return view('offers.index', [
            'offers' => $offers,
        ]);
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('allActiveChildren')
            ->where('status', 1)
            ->get();
        $categories = $this->flattenTree($categories->toArray());

        return view('offers.create', [
            'offer_types' => OfferType::all(),
            'categories' => $categories,
            'cities' => City::select(['id', 'name_' . App::getLocale() . ' AS name'])
                ->where('status', 1)
                ->get(),
            'tags' => Tag::all(),
        ]);
    }

    public function flattenTree($array)
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = [
                'id' => $item['id'],
                'name' => $item['name_' . App::getLocale()]
            ];
            $result = array_merge($result, $this->flattenTree($item['all_active_children']));
        }
        return $result;
    }

    public function store(OfferRequest $request)
    {
        if (auth()->user()->role == 'Store Owner')
            $offer = new Offer($request->safe()->except('offer_type_id'));
        else
            $offer = new Offer($request->validated());

        $offer->user_id = auth()->id();
        if (auth()->user()->role == 'Store Owner')
            $offer->offer_type_id = 1;
        $offer->save();

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
                $filePath = $file->store('uploaded_images', 'public');
                Image::create([
                    'name' => basename($filePath),
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

        $categories = Category::whereNull('parent_id')
            ->with('allActiveChildren')
            ->where('status', 1)
            ->get();
        $categories = $this->flattenTree($categories->toArray());

        return view('offers.edit', [
            'offer' => $offer,
            'offer_types' => OfferType::all(),
            'categories' => $categories,
            'cities' => City::where('status', 1)->get(),
            'tags' => Tag::all(),
        ]);
    }

    public function update(OfferRequest $request, Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort('403');
        if (auth()->user()->role == 'Store Owner')
            $validated_data = $request->safe()->except('offer_type_id');
        else
            $validated_data = $request->validated();

        $offer->update($validated_data);
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

        foreach ($offer->images as $image)
            File::delete('uploaded_images/' . $image->name);

        $offer->delete();
        return redirect('/offers');
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
        return redirect()->back();
    }

    public function upload(Request $request, Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort(403);

        if ($request->isMethod('get'))
            return view('offers.images_upload', ['offer' => $offer]);

        elseif ($request->isMethod('put')) {
            $request->validate([
                'images' => 'required',
                'images.*' => 'image'
            ]);
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $image_path = $image->store('uploaded_images', 'public');
                    Image::create([
                        'name' => basename($image_path),
                        'offer_id' => $offer->id
                    ]);
                }
            }
            return back();
        }
    }

    public function upload_store(Request $request, Offer $offer)
    {
        if ($offer->user_id != auth()->id())
            return abort(403);
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
