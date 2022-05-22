@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add Store') }}</h2>
    <form action="/stores/upload_store/{{ $image_type }}/{{ $store->id }}" method="post" class="mt-4 col-6 mx-auto"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label"
                for="image">{{ $image_type == 'logo' ? __('Store Logo') : __('Store Cover') }}</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
