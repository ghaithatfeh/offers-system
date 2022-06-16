@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit Offer') }}</h2>
    <form action="/offers/{{ $offer->id }}" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Title') }}</label>
            <input id="title" name="title" class="form-control" type="text" value="{{ old('title') ?? $offer->title }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Expiry Date') }}</label>
            <input id="expiry_date" name="expiry_date" class="form-control" type="date"
                value="{{ old('expiry_date') ?? $offer->expiry_date }}">
            @error('expiry_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">{{ __('Price') }}</label>
            <input id="price" name="price" class="form-control" type="number"
                value="{{ old('price') ?? $offer->price }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">{{ __('Category') }}</label>
            <select class="form-control" name="category_id" id="category">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') != null ? ($category->id == old('category_id') ? 'selected' : '') : ($category->id == $offer->category->id ? 'selected' : '') }}>
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
                        {{ old('offer_type_id') != null ? ($offer_type->id == old('offer_type_id') ? 'selected' : '') : ($offer_type->id == $offer->offerType->id ? 'selected' : '') }}>
                        {{ $offer_type->name_en }}</option>
                @endforeach
            </select>
            @error('offer_type_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="cities">{{ __('Target Areas') }}</label>
            <select class="select2 form-control" name="cities[]" id="cities" multiple="multiple">
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ old('cities') != null ? (in_array($city->id, old('cities')) ? 'selected' : '') : (in_array($city->id, $offer->targetAreas->modelKeys()) ? 'selected' : '') }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="tags">{{ __('Tags') }}</label>
            <select class="select2 form-control" name="tags[]" id="tags" multiple="multiple">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ old('tags') != null ? (in_array($tag->id, old('tags')) ? 'selected' : '') : (in_array($tag->id, $offer->tags->modelKeys()) ? 'selected' : '') }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control" cols="30"
                rows="5">{{ old('description') ?? $offer->description }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
