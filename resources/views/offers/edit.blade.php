@extends('layouts.app')

@section('content')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css"
        integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html[lang="ar"] .datepicker {
            direction: rtl;
        }

        #expiry_date-error {
            display: none !important;
        }
    </style>

    <h2 class="text-center">{{ __('Edit Offer') }}</h2>
    <form action="/offers/{{ $offer->id }}" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Title') }}</label>
            <input id="title" name="title" class="form-control" type="text" value="{{ $offer->title }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Expiry Date') }}</label>
            <div class="input-group">
                <input id="expiry_date" name="expiry_date" class="form-control datepicker" readonly
                    value="{{ $offer->expiry_date }}">
                <label for="expiry_date" class="input-group-text">
                    <i class="fa-solid fa-calendar-days"></i>
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">{{ __('Price') }}</label>
            <input id="price" name="price" class="form-control" type="number" value="{{ $offer->price }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">{{ __('Category') }}</label>
            <select class="form-control" name="category_id" id="category">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}"
                        {{ $category['id'] == $offer->category->id ? 'selected' : '' }}>
                        {{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        @if (auth()->user()->role != 'Store Owner')
            <div class="mb-3">
                <label class="form-label" for="offer_type">{{ __('Offer Type') }}</label>
                <select class="form-control" name="offer_type_id" id="offer_type">
                    <option value=""></option>
                    @foreach ($offer_types as $offer_type)
                        <option value="{{ $offer_type->id }}"
                            {{ $offer_type->id == $offer->offerType->id ? 'selected' : '' }}>
                            {{ $offer_type->name_en }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label" for="cities">{{ __('Target Areas') }}</label>
            <select class="select2 form-control" name="cities[]" id="cities" multiple="multiple">
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ in_array($city->id, $offer->targetAreas->modelKeys()) ? 'selected' : '' }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="tags">{{ __('Tags') }}</label>
            <select class="select2 form-control" name="tags[]" id="tags" multiple="multiple">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ in_array($tag->id, $offer->tags->modelKeys()) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control" cols="30" rows="5">{{ old('description') ?? $offer->description }}</textarea>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: 'd',
            autoclose: true,
            clearBtn: true,
            todayBtn: true,
            todayHighlight: true,
            @if (Lang::locale() == 'ar')
                rtl: true
            @endif
        });
    </script>

    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\OfferRequest') !!}
@endsection
