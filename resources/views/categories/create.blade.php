@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add Category') }}</h2>
    <form action="/categories" method="post" class="mt-4 col-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name_en" name="name_en" class="form-control" type="text">
            <small class="text-danger">
                @error('name_en')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_pt">{{ __('Name Portuguese') }}</label>
            <input id="name_pt" name="name_pt" class="form-control" type="text">
            <small class="text-danger">
                @error('name_pt')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_ar">{{ __('Name Arabic') }}</label>
            <input id="name_ar" name="name_ar" class="form-control" type="text">
            <small class="text-danger">
                @error('name_ar')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="parent_id">{{ __('Parent Category') }}</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option></option>
                @foreach ($parentsCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="hidden" name="status" value="0">
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1" checked>
            <label class="form-label" for="status" title="{{ __('Deactivating category will hide it from mobile app.') }}">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
