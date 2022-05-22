@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection.select2-selection--single {
            padding: 4px 2px 8px !important;
            border: 1px solid #ced4da !important;
            height: 38px;
        }

    </style>
    <h2 class="text-center">{{ __('Edit Store') . ': ' . $store->title }}</h2>
    <form action="/stores/{{ $store->id }}" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Store Title') }}</label>
            <input id="title" name="title" class="form-control" type="text" value="{{ old('title') ?? $store->title }}">
            <small class="text-danger">
                @error('title')
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
            <textarea class="form-control" name="description" id="description" cols="30"
                rows="10">{{ old('description') ?? $store->description }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Expiry Date') }}</label>
            <input type="date" name="expiry_date" class="form-control"
                value="{{ old('expiry_date') ?? $store->expiry_date }}">
            @error('expiry_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2-single').select2({
            placeholder: '',
            allowClear: true,
            debug: true
        });
    </script>
@endsection