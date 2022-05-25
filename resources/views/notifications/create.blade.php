@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Send New Notification') }}</h2>
    <form action="/notifications" method="post" class="mt-4 col-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Notification Title') }}</label>
            <input id="title" name="title" class="form-control" type="text" value="{{ old('title') }}">
            <small class="text-danger">
                @error('title')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="body">{{ __('Notification body') }}</label>
            <textarea id="body" name="body" class="form-control" cols="30" rows="10">{{ old('body') }}</textarea>
            <small class="text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="target_type">{{ __('Target Type') }}</label>
            <select id="target_type" name="target_type" class="form-control">
                <option value="Broadcast">Broadcast</option>
                <option value="Categories">Categories</option>
                <option value="Cities">Cities</option>
                <option value="Gender">Gender</option>
            </select>
            <small class="text-danger">
                @error('target_type')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3 d-none">
            <label class="form-label" for="target_value">{{ __('Target Value') }}</label>
            <select id="target_value" name="target_value[]" class="form-control multiple" multiple="multiple">
            </select>
            <small class="text-danger">
                @error('target_value')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="d-flex">
            <button type="submit" onclick="confirm('Are you sure you want to send this notification?')"
                class="btn btn-success mx-auto">{{ __('Send') }}</button>
        </div>
    </form>
@endsection
