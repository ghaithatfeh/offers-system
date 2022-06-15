@extends('layouts.app')
@section('content')
    <div class="d-flex">
        <h2 class="">{{ __('Customers') }}</h2>

        <form action="/cities/search" method="GET" class="ms-auto">
            <div class="input-group">
                <div class="form-outline">
                    <input name="name_en" type="search" id="form1" class="form-control"
                        placeholder="{{ __('Search here') }}.." value="{{ $_GET['name_en'] ?? '' }}" />
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="alert alert-warning mt-2" role="alert">
        {{ __('NOTE: Deactivating customers will prevent them from accessing their accounts and hide all their offers.') }}
    </div>

    <table class="table text-center mt-4">
        <thead>
            <th>{{ __('#') }}</th>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($customers as $i => $customer)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $customer->first_name }}</td>
                    <td>{{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input onchange="
                                    if (confirm('{{ __('Are you sure you want to change this status?') }}'))
                                        window.location.href = '/customers/change-status/{{ $customer->id }}'
                                    else
                                        this.checked = !this.checked
                                    " class="form-check-input" type="checkbox" id="toggle-{{ $customer->id }}"
                                {{ $customer->status ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="toggle-{{ $customer->id }}">{{ $customer->status ? __('Active') : __('Inactive') }}</label>
                        </div>
                    </td>
                    <td>
                        <a href="/customers/{{ $customer->id }}" title="{{ __('View') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->appends(Request::except('page'))->links() }}
@endsection
