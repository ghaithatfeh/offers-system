@extends('layouts.app')
@section('content')
    <h1 class="text-center">{{ __('Import Offers From Excel File') }}</h1>
    <form class="mt-4 col-6 mx-auto" action="/offers/import-from-excel" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="file">{{ __('Choase File') }}</label>
            <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="file" required>
            <div class="invalid-feedback">
                {{ __('Please choose a file in this extinction: xlsx, csv.') }}
            </div>
        </div>

        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
