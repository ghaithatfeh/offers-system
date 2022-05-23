<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(10);
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
            'title' => 'required|string|min:3',
            'cover_image' => 'image',
            'logo_image' => 'image',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'expiry_date' => 'required|date|after:yesterday',
        ]);

        $request['logo'] = $this->upload_file($request, 'logo_image');
        $request['cover'] = $this->upload_file($request, 'cover_image');
        $user = User::create([
            'email' => $request->email,
            'name' => $request->user_name,
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
        ]);
    }

    public function edit(Store $store)
    {
        return view('stores.edit', [
            'store' => $store,
            'cities' => City::all(),
        ]);
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'title' => 'required|string|min:3',
            'expiry_date' => 'after:yesterday',
            'cover' => 'image',
            'logo' => 'image',
            'expiry_date' => 'required|date',
        ]);
        $store->update($request->all());
        return redirect('/stores');
    }

    public function destroy(Store $store)
    {
        $this->delete_file($store->logo);
        $this->delete_file($store->cover);
        $store->user->delete();
        return redirect('/stores');
    }

    public function delete_file($file_name)
    {
        if (file_exists(public_path('uploaded_images/' . $file_name)))
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

    public function upload(Request $request, $image_type, Store $store)
    {
        return view('stores.upload_image', ['image_type' => $image_type, 'store' => $store]);
    }

    public function upload_store(Request $request, $image_type, Store $store)
    {
        $request->validate(['image' => 'image']);
        $this->delete_file($store[$image_type]);
        $store->update([$image_type => $this->upload_file($request, 'image')]);
        return redirect('/stores');
    }
}
