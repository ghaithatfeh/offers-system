@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit Tag') }}</h2>
    <form action="/tags/{{ $tag->id }}" method="POST" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ $tag->name }}">
            <div class="valid-feedback"></div>
            <small class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
