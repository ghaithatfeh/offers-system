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
    </style>

    <h2 class="text-center">{{ __('Edit Store') . ': ' . $store->name }}</h2>
    <form action="{{ (auth()->user()->role == 'Store Owner' ? '/my-store-update/' : '/stores/') . $store->id }}"
        method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="user_name">{{ __('Owner Name') }}</label>
            <input type="text" name="user_name" class="form-control"
                value="{{ $store->user->name }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ $store->user->email }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Store Name') }}</label>
            <input id="name" name="name" class="form-control" type="text"
                value="{{ $store->name }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="city">{{ __('Store City') }}</label>
            <select class="select2-single form-control" name="city_id" id="city">
                <option value=""></option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ $city->id == $store->city_id ? 'selected' : '' }}>
                        {{ $city['name_' . App::getLocale()] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $store->description }}</textarea>
        </div>
        @if (auth()->user()->role != 'Store Owner')
            <div class="mb-3">
                <label class="form-label" for="expiry_date">{{ __('Valid Until') }}</label>
                <div class="d-flex">
                    <div class="w-100">
                        <input name="expiry_date" id="expiry_date" class="form-control datepicker" readonly
                            value="{{ $store->expiry_date }}">
                    </div>
                    <label for="expiry_date" class="input-group-text">
                        <i class="fa-solid fa-calendar-days"></i>
                    </label>
                </div>
            </div>
        @endif
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>

    <script>
        $('.select2-single').select2({
            placeholder: '',
            allowClear: true,
            debug: true
        });
    </script>
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
            todayBtn: true,
            todayHighlight: true,
            @if (Lang::locale() == 'ar')
                rtl: true
            @endif
        });
    </script>

    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UpdateStoreRequest') !!}
@endsection
