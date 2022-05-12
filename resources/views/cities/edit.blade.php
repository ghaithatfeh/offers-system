@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add City') }}</h2>
    <form action="/cities/{{ $city->id }}" method="POST" class="mt-4 col-6 mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name_en" name="name_en" class="form-control" type="text" value="{{ $city->name_en }}">
            <div class="valid-feedback"></div>
            <small class="text-danger">
                @error('name_en')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_pt">{{ __('Name Portuguese') }}</label>
            <input id="name_pt" name="name_pt" class="form-control" type="text" value="{{ $city->name_pt }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_ar">{{ __('Name Arabic') }}</label>
            <input id="name_ar" name="name_ar" class="form-control" type="text" value="{{ $city->name_ar }}">
        </div>
        <div class="mb-3">
            <input id="status" name="status" class="form-check-input" type="checkbox"
                {{ $city->status ? 'checked' : '' }}>
            <label class="form-label" for="status">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
