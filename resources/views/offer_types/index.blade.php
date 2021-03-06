@extends('layouts.app')

@section('content')
<div class="d-flex mt-4">
        <h2 class="">{{ __('Offers Types') }}</h2>
        <form action="/offer_types/search" method="GET" class="ms-auto">
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
            <th>{{ __('Name English') }}</th>
            <th>{{ __('Name Portuguese') }}</th>
            <th>{{ __('Name Arabic') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($offer_types as $i => $offer_type)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $offer_type->name_en }}</td>
                    <td>{{ $offer_type->name_pt }}</td>
                    <td>{{ $offer_type->name_ar }}</td>
                    <td>{{ $offer_type->price . ' ' . __('validation.currency')}}</td>
                    <td>
                        <a href="/offer_types/{{ $offer_type->id }}" title="{{ __('View') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/offer_types/{{ $offer_type->id }}/edit" title="{{ __('Edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ $offer_types->appends(Request::except('page'))->links() }}
@endsection
