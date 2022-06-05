@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add City') }}</h2>
    <form action="/cities" method="post" class="mt-4 col-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name_en" name="name_en" class="form-control" type="text">
            <div class="valid-feedback"></div>
            @error('name_en')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_pt">{{ __('Name Portuguese') }}</label>
            <input id="name_pt" name="name_pt" class="form-control" type="text">
            @error('name_pt')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_ar">{{ __('Name Arabic') }}</label>
            <input id="name_ar" name="name_ar" class="form-control" type="text">
            @error('name_ar')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="mb-3 form-check">
            <input type='hidden' value='0' name='status'>
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1"checked>
            <label class="form-label" for="status" title="{{ __('Deactivating city will hide it from mobile app.') }}">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
