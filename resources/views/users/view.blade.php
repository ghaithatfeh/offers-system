@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex">
        <h2>{{ __('User Details') }}</h2>
        <div class="ms-auto d-flex align-items-center">
            <a class="btn btn-primary mx-1" href="/users/{{ $user->id }}/edit">{{ __('Edit') }}</a>
            @if (!($user->offers->count() || $user->store->count() || $user->reviewedOffers->count()))
                <a class="btn btn-danger mx-1" href=""
                    onclick="event.preventDefault();confirm('{{ __('Are you sure you want to delete this :item?', ['item'=> __('user')]) }}') ? document.querySelector('#form-delete').submit() : '';">{{ __('Delete') }}</a>
                <form id="form-delete" action="/users/{{ $user->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name') }}</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>{{ __('Email') }}</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>{{ __('Role') }}</td>
                <td>{{ __($user->role) }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $user->status ? __('Active') : __('Inactive') }}</td>
            </tr>
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $user->updated_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection
