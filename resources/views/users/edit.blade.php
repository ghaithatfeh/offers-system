@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Edit User') . ': ' . $user->name }}</h2>
    <form action="/users/{{ $user->id }}" method="post" class="mt-4 col-6 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input id="name" name="name" class="form-control" type="text" value="{{ old('name') ?? $user->name }}">
            <small class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') ?? $user->email }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        @php
            $roles = [__('Admin'), __('Supervisor'), __('Store Owner')];
        @endphp
        <div class="mb-3">
            <div class="form-group">
                <label for="role">{{ __('Role') }}</label>
                <select class="form-control" name="role" id="role">
                    @foreach ($roles as $role)
                        <option
                            {{ old('role') != null ? (old('role') == $role ? 'selected' : '') : ($user->role == $role ? 'selected' : '') }}
                            vlaue="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input name="status" type="hidden" value="0">
            <input id="status" name="status" class="form-check-input" type="checkbox" value="1"
                {{ old('status') != null ? (old('status') ? 'checked' : '') : ($user->status ? 'checked' : '') }}>
            <label class="form-label" for="status" title="">{{ __('Active') }}</label>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary mx-auto">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
