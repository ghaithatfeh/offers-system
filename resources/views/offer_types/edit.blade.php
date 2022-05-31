@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit Offer Type') }}</h2>
    <form action="/offer_types/{{ $offer_type->id }}" method="post" class="mt-4 col-6 mx-auto">
        @method('put')
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name_en" name="name_en" class="form-control" type="text" value="{{ old('name_en') ?? $offer_type->name_en }}">
            @error('name_en')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_pt">{{ __('Name Portuguese') }}</label>
            <input id="name_pt" name="name_pt" class="form-control" type="text" value="{{ old('name_pt') ?? $offer_type->name_pt }}">
            @error('name_pt')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_ar">{{ __('Name Arabic') }}</label>
            <input id="name_ar" name="name_ar" class="form-control" type="text" value="{{ old('name_ar') ?? $offer_type->name_ar }}">
            @error('name_ar')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">{{ __('Price') }}</label>
            <input id="price" name="price" class="form-control" type="number" value="{{ old('price') ?? $offer_type->price }}">
            @error('price')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control" cols="30"
                rows="5">{{ old('description') ?? $offer_type->description }}</textarea>
            @error('description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
