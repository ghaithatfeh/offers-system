@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection.select2-selection--multiple {
            padding: 4px 2px 8px !important;
            border: 1px solid #ced4da !important;
        }

    </style>

    <h2 class="text-center">{{ __('Add Offer') }}</h2>
    <form action="/offers" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Title') }}</label>
            <input id="title" name="title" class="form-control" type="text" value="{{ old('title') }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Expiry Date') }}</label>
            <input id="expiry_date" name="expiry_date" class="form-control" type="date" value="{{ old('expiry_date') }}">
            @error('expiry_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">{{ __('Price') }}</label>
            <input id="price" name="price" class="form-control" type="number" value="{{ old('price') }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">{{ __('Category') }}</label>
            <select class="form-control" name="category_id" id="category">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>
                        {{ $category->name_en }}</option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="offer_type">{{ __('Offer Type') }}</label>
            <select class="form-control" name="offer_type_id" id="offer_type">
                <option value=""></option>
                @foreach ($offer_types as $offer_type)
                    <option value="{{ $offer_type->id }}"
                        {{ $offer_type->id == old('offer_type_id') ? 'selected' : '' }}>
                        {{ $offer_type->name_en }}</option>
                @endforeach
            </select>
            @error('offer_type_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="cities">{{ __('Target Areas') }}</label>
            <select class="select2-multiple form-control" name="cities[]" id="cities" multiple="multiple">
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ in_array($city->id, old('cities') ?? []) ? 'selected' : '' }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="tags">{{ __('Tags') }}</label>
            <select class="select2-multiple form-control" name="tags[]" id="tags" multiple="multiple">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags') ?? []) ? 'selected' : '' }}>
                        {{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control" cols="30"
                rows="5">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="images">{{ __('Upload Images') }}</label>
            <input type="file" id="images" name="images[]" class="form-control" multiple>
            @error('images.*')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2-multiple').select2({
            placeholder: '',
            allowClear: true,
            closeOnSelect: false,
            debug: true
            // tags: true,
        });
    </script>
@endsection
