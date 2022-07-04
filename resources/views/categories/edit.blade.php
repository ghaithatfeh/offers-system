@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit Category') }}</h2>
    <form action="/categories/{{ $category->id }}" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @method('put')
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name English') }}</label>
            <input id="name_en" name="name_en" class="form-control" type="text"
                value="{{ $category->name_en }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_pt">{{ __('Name Portuguese') }}</label>
            <input id="name_pt" name="name_pt" class="form-control" type="text"
                value="{{ $category->name_pt }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="name_ar">{{ __('Name Arabic') }}</label>
            <input id="name_ar" name="name_ar" class="form-control" type="text"
                value="{{ $category->name_ar }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="parent_id">{{ __('Parent Category') }}</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option></option>
                @foreach ($parentsCategories as $parentCategory)
                    <option
                        {{ old('parent_id') != null ? (old('parent_id') == $parentCategory->id ? 'selected' : '') : ($category->parent_id == $parentCategory->id ? 'selected' : '') }}
                        value="{{ $parentCategory->id }}">
                        {{ $parentCategory->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="hidden" name="status" value="0">
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1"
                {{ $category->status ? 'checked' : '' }}>
            <label class="form-label" for="status" title="{{ __('Deactivating category will hide it from mobile app.') }}">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection

@section('script')
    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CategoryRequest') !!}
@endsection
