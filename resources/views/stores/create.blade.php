@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add Store') }}</h2>
    <form action="/stores" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Store Name') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ old('name') }}">
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
                    <option value="{{ $city->id }}" {{ $city->id == old('city_id') ? 'selected' : '' }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
            @error('city_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="logo">{{ __('Store Logo') }}</label>
            <input type="file" name="logo_image" class="form-control">
            @error('logo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="cover">{{ __('Store Cover') }}</label>
            <input type="file" name="cover_image" class="form-control">
            @error('cover')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" id="description" cols="30"
                rows="10">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="user_name">{{ __('Owner Name') }}</label>
            <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}">
            @error('user_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" class="form-control">
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="expiry_date">{{ __('Valid Until') }}</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
            @error('expiry_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="alert alert-warning">
            {{ __('A default image will be displayed for logo and cover if images are not uploaded.') }}
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
    
    <script>
        $('.select2-single').select2({
            placeholder: '',
            allowClear: true,
            closeOnSelect: false,
            debug: true
        });
    </script>
@endsection
