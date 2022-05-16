@extends('layouts.app')

@section('content')
    {{ Breadcrumbs::render('create_tag') }}
    <h2 class="text-center">{{ __('Add Tag') }}</h2>
    <form action="/tags" method="post" class="mt-4 col-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ old('name') }}">
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
