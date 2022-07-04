@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit User') . ': ' . $user->name }}</h2>
    <form action="/users/{{ $user->id }}" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ $user->name }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
        </div>
        @php
            $roles = ['Admin', 'Supervisor'];
        @endphp
        <div class="mb-3">
            <div class="form-group">
                <label for="role">{{ __('Role') }}</label>
                <select class="form-control" name="role" id="role">
                    @foreach ($roles as $role)
                        <option {{ $user->role == $role ? 'selected' : '' }} value="{{ $role }}">
                            {{ __($role) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input name="status" type="hidden" value="0">
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1"
                {{ $user->status ? 'checked' : '' }}>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateUserRequest') !!}
@endsection