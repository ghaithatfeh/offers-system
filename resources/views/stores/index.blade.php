@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Stores') }}</h2>
    <div class="alert alert-warning">
        {{ __('NOTE: You can\'t delete a store if there offer releted to it, you can deactivate it. Inactive store and its offers won’t be displayed in mobile application.') }}
    </div>
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
            <th>{{ __('#') }}</th>
            <th>{{ __('Store Owner') }}</th>
            <th>{{ __('Store Name') }}</th>
            <th>{{ __('City') }}</th>
            <th>{{ __('Expiry Date') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($stores as $i => $store)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $store->user->name }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->city->name_en }}</td>
                    <td>{{ $store->expiry_date }}</td>
                    <td>{{ __($store->status) }}</td>
                    <td>
                        <a href="/stores/{{ $store->id }}" title="{{ __('View') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/stores/{{ $store->id }}/edit" title="{{ __('Edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if (!$store->user->offers->count())
                            <form class="d-inline-block" method="POST" action="/stores/{{ $store->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 bg-transparent text-danger px-0" title="{{ __('Delete') }}"
                                    type="submit"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('store')]) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $stores->appends(Request::except('page'))->links() }}
@endsection
