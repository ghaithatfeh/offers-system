@extends('layouts.app')
@section('content')
    <h1 class="text-center">{{ __('Import Offers From Excel File') }}</h1>
    <form class="mt-4 col-12 col-md-8 col-xl-6 mx-auto" action="/bulk-offers/import-from-excel" method="POST"
        enctype="multipart/form-data">
        <div class="alert alert-warning" style="line-height: 1.7;">
            {!! __('The excel file must contain columns with the following headers:<br>Title(required), Price(required), Expiry Date(optional), Tags(optional), Description(optional).<br>You can download and fill out the template file from ') !!}
            <a class="text-primary" href="/uploaded_images/excel_files/offer.xlsx">{{ __('here') }}</a>. <br>
            {{ __('When writing multiple tags, each tag must be written on a new line. You can create a new line in Excel by pressing Alt + Enter.') }}
        </div>
        @csrf
        <div class="mb-3">
            <label class="form-label" for="category">{{ __('Category') }}</label>
            <select class="form-control" name="category_id" id="category">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" {{ $category['id'] == old('category_id') ? 'selected' : '' }}>
                        {{ $category['name_en'] }}</option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="cities">{{ __('Target Areas') }}</label>
            <select class="select2 form-control" name="cities[]" id="cities" multiple="multiple">
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ in_array($city->id, old('cities') ?? []) ? 'selected' : '' }}>
                        {{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="file">{{ __('Choase File') }}</label>
            <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="file"
                required>
            @error('file')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @if (session()->has('file'))
                @foreach (session()->get('file') as $row_errors)
                    @foreach ($row_errors as $field_error)
                        <small class="text-danger d-block my-2">{{ $field_error }}</small>
                    @endforeach
                @endforeach
            @endif
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
