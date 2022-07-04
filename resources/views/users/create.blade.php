@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Add User') }}</h2>
    <form action="/users" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        @php
            $roles = ['Admin', 'Supervisor'];
        @endphp
        <div class="mb-3">
            <div class="form-group">
                <label for="role">{{ __('Role') }}</label>
                <select class="form-control" name="role" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">
                            {{ __($role) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input name="status" type="hidden" value="0">
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1" checked>
            <label class="form-label" for="status" title="">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection

@section('script')
    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UserRequest') !!}
@endsection