@extends('layouts.app')
@section('content')
    <h2 class="text-center">{{ __('Images Of Offer') . ': ' . $offer->title }}</h2>
    <form class="mt-5 col-12 col-md-7 mx-auto row" action="/offers/upload/{{ $offer->id }}" method="post"
        enctype="multipart/form-data">
        @method('put')
        @csrf
        <label class="form-label" for="images">{{ __('Upload Images') }}</label>
        <div class="form-group col-10">
            <input type="file"
                class="form-control {{ $errors->has('images') || $errors->has('images.*') ? 'is-invalid' : '' }}"
                name="images[]" id="images" multiple>
            @error('images.*')
                <small class="text-danger">{{ __('The files must be of type image.') }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary col-2 mb-auto">
            {{ __('Submit') }}
        </button>
    </form>
    <div class="row mt-4 mx-auto justify-content-center">
        @forelse ($offer->images as $image)
            <div class="col-6 col-md-4 mt-4 d-flex flex-column justify-content-end">
                <img class="img-fluid rounded-top" src="{{ asset('uploaded_images/' . $image->name) }}">
                <form action="/offers/delete_image/{{ $image->id }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger rounded-0 rounded-bottom w-100"
                        onclick="return confirm('{{ __('Are you sure you want to delete this image from your :attribute?', ['attribute' => __('offer')]) }}')">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        {{ __('Delete image') }}
                    </button>
                </form>
            </div>
        @empty
            <div class="col-12 col-md-7">
                <div class="alert alert-warning">{{ __('No photos have been uploaded yet.') }}</div>
            </div>
        @endforelse
    </div>
@endsection
