@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Users') }}</h2>
    <div class="d-flex mt-4">
        <a href="/users/create" class="btn btn-success text-nowrap me-3">{{ __('Add User') }}</a>

        <form action="/users/search" method="GET" class="ms-auto">
            <div class="input-group d-flex flex-nowrap">
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

    <div class="table-responsive">
        <table class="table text-center mt-4">
            <thead>
                <th>{{ __('#') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ __($user->role) }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input onchange="
                                            if (confirm('{{ __('Are you sure you want to change this status?') }}'))
                                                window.location.href = '/users/change-status/{{ $user->id }}'
                                            else
                                                this.checked = !this.checked" class="form-check-input" type="checkbox"
                                    id="toggle-{{ $user->id }}" {{ $user->status ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="toggle-{{ $user->id }}">{{ $user->status ? __('Active') : __('Inactive') }}</label>
                            </div>
                        </td>
                        <td>
                            <a href="/users/{{ $user->id }}" title="{{ __('View') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/users/{{ $user->id }}/edit" title="{{ __('Edit') }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if (!($user->offers->count() || $user->store->count() || $user->reviewedOffers->count()))
                                <form class="d-inline-block" method="POST" action="/users/{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-0 bg-transparent text-danger px-0" title="{{ __('Delete') }}"
                                        type="submit"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('user')]) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->appends(Request::except('page'))->links() }}
@endsection
