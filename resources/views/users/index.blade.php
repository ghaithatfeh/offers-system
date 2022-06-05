@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Users') }}</h2>
    <div class="d-flex mt-4">
        <a href="/users/create" class="btn btn-success">{{ __('Add User') }}</a>

        <form action="/users/search" method="GET" class="ms-auto">
            <div class="input-group">
                <div class="form-outline">
                    <input name="search" type="search" id="form1" class="form-control"
                        placeholder="{{ __('Search here') }}.." value="{{ $_GET['search'] ?? '' }}" />
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <table class="table text-center mt-4">
        <thead>
            <th>{{ __('Id') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Role') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        {{ $user->status ? 'Active' : 'Inactive' }}
                        <a href="/user/change-status/{{ $user->id }}" class="text-primary"
                            onclick="return confirm('Are you sure you want to change this user status?')">
                            {{ $user->status ? '(Deactivate)' : '(Activate)' }}
                        </a>
                    </td>
                    <td>
                        <a href="/users/{{ $user->id }}" title="Edit">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/users/{{ $user->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if (!json_decode($user->children))
                            <form class="d-inline-block" method="POST" action="/users/{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->appends(Request::except('page'))->links() }}
@endsection
