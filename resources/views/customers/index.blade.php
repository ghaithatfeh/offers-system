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
                        {{ $customer->status ? 'Active' : 'Inactive' }}
                        <a href="/customer/change-status/{{ $customer->id }}" class="text-primary">
                            {{ $customer->status ? '(Deactive)' : '(Active)' }}
                        </a>
                    </td>
                    <td>
                        <a href="/customers/{{ $customer->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form class="d-inline-block" method="POST" action="/customers/{{ $customer->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                onclick="return confirm('Are you sure you want to delete this customer?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->appends(Request::except('page'))->links() }}
@endsection
