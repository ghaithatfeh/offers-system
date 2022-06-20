<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Offer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::orderByDesc('id')->paginate(10);
        return view('stores.index', [
            'stores' => $stores,
        ]);
    }

    public function create()
    {
        $cities = City::all();
        return view('stores.create', ['cities' => $cities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'cover_image' => 'image',
            'logo_image' => 'image',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'expiry_date' => 'required|date|after:yesterday',
        ]);

        $request['logo'] = $this->upload_file($request, 'logo_image');
        $request['cover'] = $this->upload_file($request, 'cover_image');
        $user = User::create([
            'email' => $request->email,
            'name' => $request->user_name,
            'role' => 'Store Owner',
            'password' => Hash::make($request->password),
        ]);

        $request['user_id'] = $user->id;

        Store::create($request->all());
        return redirect('/stores');
    }

    public function show(Store $store)
    {
        return view('stores.view', [
            'store' => $store,
            'offers' => Offer::where('user_id', $store->user_id)->paginate(10)
        ]);
    }
    public function myStore()
    {
        return view('stores.view', [
            'store' => Store::where('user_id', auth()->id())->first(),
        ]);
    }

    public function edit(Store $store, $store_id = 0)
    {
        if ($store_id != 0)
            $store = Store::where('user_id', $store_id)->first();
        return view('stores.edit', [
            'store' => $store,
            'cities' => City::all(),
        ]);
    }

    public function myStoreUpdate(Request $request)
    {
        $store = Store::where('user_id', auth()->id())->first();
        $request->validate([
            'name' => 'required|string|min:3',
            'city_id' => 'numeric',
            'description' => 'string',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
        $store->update($request->all(['name', 'city_id', 'description']));
        $store->user->update([
            'name' => $request->user_name,
            'email' => $request->email
        ]);
        return redirect('/my-store');
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'expiry_date' => 'required|date|after:yesterday'
        ]);
        $store->update($request->validate());
        $store->user->update([
            'name' => $request->user_name,
            'email' => $request->email
        ]);
        return redirect('/stores');
    }

    public function destroy(Store $store)
    {
        if ($store->user->offers->count())
            return abort(403);
        $this->delete_file($store->logo);
        $this->delete_file($store->cover);
        $store->user->delete();
        return redirect('/stores');
    }

    public function delete_file($file_name)
    {
        if ($file_name != null && file_exists(public_path('uploaded_images/' . $file_name)))
            unlink(public_path('uploaded_images/' . $file_name));
    }

    public function upload_file($request, $file_name)
    {
        if ($request->hasFile($file_name)) {
            if (!file_exists(public_path('uploaded_images'))) {
                mkdir(public_path('uploaded_images'), 0777, true);
            }
            $file = $request->file($file_name);
            $file_name = time() . '_' . $file->getClientOriginalName();
            if ($file->move(public_path('uploaded_images'), $file_name)) {
                return $file_name;
            }
            return false;
        }
    }

    public function upload($image_type, Store $store)
    {
        if (auth()->user()->role == 'Store Owner' &&  $store->user_id != auth()->id())
            return abort(403);
        return view('stores.image_upload', ['image_type' => $image_type, 'store' => $store]);
    }

    public function upload_store(Request $request, $image_type, Store $store)
    {
        if (auth()->user()->role == 'Store Owner' &&  $store->user_id != auth()->id())
            return abort(403);
        $request->validate(['image' => 'image|required']);
        $store->$image_type ? $this->delete_file($store[$image_type]) : '';
        $store->update([$image_type => $this->upload_file($request, 'image')]);
        if (auth()->user()->role == 'Store Owner')
            return redirect('/my-store');
        return redirect('/stores/' . $store->id);
    }

    public function delete_image($image_type, Store $store)
    {
        if (auth()->user()->role == 'Store Owner' &&  $store->user_id != auth()->id())
            return abort(403);
        $store->$image_type ? $this->delete_file($store[$image_type]) : '';
        $store->update([$image_type => null]);
        return back();
    }
}
