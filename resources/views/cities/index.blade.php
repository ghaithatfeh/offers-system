@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Cities') }}</h2>
    <div class="d-flex mt-4">
        <a href="/cities/create" class="btn btn-success">{{ __('Add City') }}</a>

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
            <th>{{ __('Name English') }}</th>
            <th>{{ __('Name Portuguese') }}</th>
            <th>{{ __('Name Arabic') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name_en }}</td>
                    <td>{!! $city->name_pt ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>{!! $city->name_ar ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>
                        {{ $city->status ? 'Active' : 'Inactive' }}
                        <a href="/cities/change-status/{{ $city->id }}" class="text-primary">
                            {{ $city->status ? '(Deactivate)' : '(Activate)' }}
                        </a>
                    </td>
                    <td>
                        <a href="/cities/{{ $city->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/cities/{{ $city->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if (json_decode($city->offers))
                            <form class="d-inline-block" method="POST" action="/cities/{{ $city->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 text-danger bg-transparent px-0" title="Delete" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this city?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $cities->appends(Request::except('page'))->links() }}
@endsection
