@extends('layouts.app')
@section('content')
    <h1 class="text-center">{{ __('Import Offers From Excel File') }}</h1>
    <form class="mt-4 col-12 col-md-8 col-xl-6 mx-auto" action="/bulk-offers/import-from-excel" method="POST"
        enctype="multipart/form-data">
        <div class="alert alert-warning">
            {!! __('The excel file must contain columns with the following headers:<br>
            Title(required), Price(required), Expiry Date(optional), Description(optional).<br>
            You can download and fill out the template file from ') !!}
            <a class="text-primary" href="/uploaded_images/excel_files/offer.xlsx">{{__('here')}}</a>.
        </div>
        @csrf
        <div class="mb-3">
            <label class="form-label" for="file">{{ __('Choase File') }}</label>
            <input class="form-control @if ($errors->any()) is-invalid @endif" type="file" name="file" id="file"
                required>
            <div class="invalid-feedback alert alert-danger mt-2 fs-6">
                {!! implode('', $errors->all(':message<br>')) !!}
            </div>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
