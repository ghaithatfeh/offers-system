@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add Tag') }}</h2>
    <form action="/tags" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @if (request()->session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ request()->session()->get('success') }}
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name_en">{{ __('Name') }}</label>
            <input id="name" name="name" class="form-control" type="text">
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection

@section('script')
    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\TagRequest') !!}
@endsection
