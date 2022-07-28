<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateStoreRequest;
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

    public function store(StoreRequest $request)
    {
        $store = new Store($request->validated());
        $store->logo = $this->upload_file($request, 'logo_image');
        $store->cover = $this->upload_file($request, 'cover_image');
        $user = User::create([
            'email' => $request->email,
            'name' => $request->user_name,
            'role' => 'Store Owner',
            'password' => Hash::make($request->password),
        ]);
        $store->user_id = $user->id;

        $store->save();
        return redirect('/stores');
    }

    public function show(Store $store)
    {
        return view('stores.view', [
            'store' =>  $store,
            'offers' => Offer::where('user_id', $store->user_id)->paginate(10)
        ]);
    }
    public function myStore()
    {
        return view('stores.view', [
            'store' => Store::where('user_id', auth()->id())->first(),
        ]);
    }

    public function edit(Store $store)
    {
        return view('stores.edit', [
            'store' => $store,
            'cities' => City::all(),
        ]);
    }

    public function myStoreUpdate(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->safe()->except(['expiry_date']));
        $store->user->update([
            'name' => $request->user_name,
            'email' => $request->email
        ]);
        return redirect('/my-store');
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->validated());
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
            $file_name = $request->file($file_name)->store('uploaded_images', 'public');
            return basename($file_name);
        }
        return false;
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

    public function expandExpiry(Request $request, Store $store)
    {
        if ($store->status == 'Inactive')
            return abort(403);

        $request->validate([
            'expiry_date' => 'after:yesterday',
        ]);
        $request['status'] = 'Active';
        $store->update($request->all());
        $store->user->update(['status' => 1]);

        return back();
    }

    public function changeStatus(Store $store)
    {
        if ($store->status == 'Active') {
            $store->update(['status' => 'Inactive']);
            $store->user->update(['status' => 0]);
        } elseif ($store->status == 'Inactive') {
            $store->update(['status' => 'Active']);
            $store->user->update(['status' => 1]);
        }
        return back();
    }
}
