@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Offers') }}</h2>
    <div class="d-flex mt-4">
        <a href="/offers/create" class="btn btn-success">{{ __('Add Offer') }}</a>
        <form action="/offer/search" method="GET" class="ms-auto">
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
            <th>{{ __('Titile') }}</th>
            <th>{{ __('Expiry Date') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr>
                    <td>{{ $offer->id }}</td>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->expiry_date }}</td>
                    <td>{{ $offer->price }}</td>
                    <td>{{ $offer->status }}</td>
                    <td>
                        <a href="/offers/{{ $offer->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/offers/{{ $offer->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form class="d-inline-block" method="POST" action="/offers/{{ $offer->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                onclick="return confirm('Are you sure you want to delete this offer type?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $offers->appends(Request::except('page'))->links() }}
@endsection
