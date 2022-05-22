@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Stores') }}</h2>
    <div class="d-flex mt-4">
        <a href="/stores/create" class="btn btn-success">{{ __('Add Store') }}</a>

        <form action="/stores/search" method="GET" class="ms-auto">
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
            <th>{{ __('Store Owner') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('City') }}</th>
            <th>{{ __('Expiry Date') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($stores as $store)
                <tr>
                    <td>{{ $store->id }}</td>
                    <td>{{ $store->user->name }}</td>
                    <td>{{ $store->title }}</td>
                    <td>{{ $store->city->name_en }}</td>
                    <td>{{ $store->expiry_date }}</td>
                    <td>{{ $store->status }}</td>
                    <td>
                        <a href="/stores/{{ $store->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/stores/{{ $store->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form class="d-inline-block" method="POST" action="/stores/{{ $store->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                onclick="return confirm('Are you sure you want to delete this store?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $stores->appends(Request::except('page'))->links() }}
@endsection
