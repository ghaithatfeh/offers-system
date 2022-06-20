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
    <form action="{{ auth()->user()->role == 'Store Owner' ? '/my-store-update' : '/stores/' . $store->id }}" method="post"
        class="mt-4 col-12 col-md-8 col-lg-6 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="user_name">{{ __('Owner Name') }}</label>
            <input type="text" name="user_name" class="form-control"
                value="{{ old('user_name') ?? $store->user->name }}">
            @error('user_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') ?? $store->user->email }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Store Name') }}</label>
            <input id="name" name="name" class="form-control" type="text"
                value="{{ old('name') ?? $store->name }}">
            <small class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="city">{{ __('Store City') }}</label>
            <select class="select2-single form-control" name="city_id" id="city">
                <option value=""></option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ old('city_id') != null ? ($city->id == old('city_id') ? 'selected' : '') : ($city->id == $store->city_id ? 'selected' : '') }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
            @error('city_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') ?? $store->description }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        @if (auth()->user()->role != 'Store Owner')
            <div class="mb-3">
                <label class="form-label" for="expiry_date">{{ __('Valid Until') }}</label>
                <div class="input-group">
                    <input name="expiry_date" id="expiry_date" class="form-control datepicker" readonly
                        value="{{ old('expiry_date') ?? $store->expiry_date }}">
                    <label for="expiry_date" class="input-group-text">
                        <i class="fa-solid fa-calendar-days"></i>
                    </label>
                </div>
                @error('expiry_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
@endsection
