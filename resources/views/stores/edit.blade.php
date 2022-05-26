@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit Store') . ': ' . $store->name }}</h2>
    <form action="/stores/{{ $store->id }}" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Store name') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ old('name') ?? $store->name }}">
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
    
    <script>
        $('.select2-single').select2({
            placeholder: '',
            allowClear: true,
            debug: true
        });
    </script>
@endsection
