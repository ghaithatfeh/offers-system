@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Cities') }}</h2>
    <div class="alert alert-warning">
        {{ __('NOTE: You can\'t delete a city if there offer releted to it, you can deactivate it. Inactive city and its offers won’t be displayed in mobile application.') }}
    </div>
    <div class="d-flex mt-4">
        <a href="/cities/create" class="btn btn-success text-nowrap me-3">{{ __('Add City') }}</a>

        <form action="/cities/search" method="GET" class="ms-auto">
            <div class="input-group d-flex flex-nowrap">
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
    <div class="table-responsive">
        <table class="table text-center mt-4">
            <thead>
                <th>{{ __('#') }}</th>
                <th>{{ __('Name English') }}</th>
                <th>{{ __('Name Portuguese') }}</th>
                <th>{{ __('Name Arabic') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                @foreach ($cities as $i => $city)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $city->name_en }}</td>
                        <td>{{ $city->name_pt }}</td>
                        <td>{{ $city->name_ar }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input
                                    onchange="
                                    if (confirm('{{ __('Are you sure you want to change this status?') }}'))
                                        window.location.href = '/cities/change-status/{{ $city->id }}'
                                    else
                                        this.checked = !this.checked
                                    "
                                    class="form-check-input" type="checkbox" id="toggle-{{ $city->id }}"
                                    {{ $city->status ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="toggle-{{ $city->id }}">{{ $city->status ? __('Active') : __('Inactive') }}</label>
                            </div>
                        </td>
                        <td>
                            <a href="/cities/{{ $city->id }}" title="{{ __('View') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/cities/{{ $city->id }}/edit" title="{{ __('Edit') }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if (!json_decode($city->offers))
                                <form class="d-inline-block" method="POST" action="/cities/{{ $city->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-0 text-danger bg-transparent px-0" title="{{ __('Delete') }}"
                                        type="submit"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('city')]) }}')">
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
    {{ $cities->appends(Request::except('page'))->links() }}
@endsection
