@extends('layouts.app')
{{-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet"> --}}
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
            <th>{{ __('Id') }}</th>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->first_name }}</td>
                    <td>{{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input onchange="window.location.href = '/customers/change-status/{{ $customer->id }}'" class="form-check-input" type="checkbox" id="toggle-{{$customer->id}}" {{ $customer->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="toggle-{{$customer->id}}">{{ $customer->status ? 'Active' : 'Inactive' }}</label>
                        </div>
                    </td>
                    <td>
                        <a href="/customers/{{ $customer->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->appends(Request::except('page'))->links() }}
@endsection

@section('script')
    {{-- <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> --}}
@endsection
