@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Offers Types') }}</h2>
    <div class="d-flex mt-4">

        <form action="/offer_types/search" method="GET" class="ms-auto">
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
            <th>{{ __('Name English') }}</th>
            <th>{{ __('Name Portuguese') }}</th>
            <th>{{ __('Name Arabic') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($offer_types as $offer_type)
                <tr>
                    <td>{{ $offer_type->id }}</td>
                    <td>{{ $offer_type->name_en }}</td>
                    <td>{!! $offer_type->name_pt ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>{!! $offer_type->name_ar ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>{{ $offer_type->price }}</td>
                    <td>
                        {{ $offer_type->status ? 'Active' : 'Inactive' }}
                        <a href="/offer_types/change-status/{{ $offer_type->id }}" class="text-primary">
                            {{ $offer_type->status ? '(Deactive)' : '(Active)' }}
                        </a>
                    </td>
                    <td>
                        <a href="/offer_types/{{ $offer_type->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/offer_types/{{ $offer_type->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $offer_types->appends(Request::except('page'))->links() }}
@endsection
