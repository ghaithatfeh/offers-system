@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection.select2-selection--multiple{
            padding: 6px 12px !important; border: 1px solid #ced4da !important;
        }
    </style>

    <h2 class="text-center">{{ __('Create Offer') }}</h2>
    <form action="/offers" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Title') }}</label>
            <input id="title" name="title" class="form-control" type="text">
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Expiry Date') }}</label>
            <input id="expiry_date" name="expiry_date" class="form-control" type="date">
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">{{ __('Price') }}</label>
            <input id="price" name="price" class="form-control" type="number">
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">{{ __('Category') }}</label>
            <select class="form-control" name="category_id" id="category">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="tags">{{ __('Tags') }}</label>
            <select class="select2-multiple form-control" name="tags[]" id="tags" multiple="multiple">
                <option value=""></option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="cities">{{ __('Target Areas') }}</label>
            <select class="select2-multiple form-control" name="cities[]" id="cities" multiple="multiple">
                <option value=""></option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="offer_type">{{ __('Offer Type') }}</label>
            <select class="form-control" name="offer_type_id" id="offer_type">
                <option value=""></option>
                @foreach ($offer_types as $offer_type)
                    <option value="{{ $offer_type->id }}">{{ $offer_type->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control" cols="30" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="images">{{ __('Images') }}</label>
            <input type="file" id="images" name="images[]" class="form-control" multiple>
        </div>
        {{-- <div class="mb-3">
            <input id="status" name="status" class="form-check-input" type="checkbox" checked>
            <label class="form-label" for="status">{{ __('Active') }}</label>
        </div> --}}
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true,
                theme: "classic"
            });
        });
    </script>
@endsection
