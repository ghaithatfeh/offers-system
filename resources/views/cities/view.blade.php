@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex justify-content-between">
        <h2>{{ __('City Details') }}</h2>
        <div>
            <a href="/cities/{{ $city->id }}/edit" class="btn btn-primary">{{ __('Edit') }}</a>
            @if (!$city->offers->count())
                <form class="d-inline-block" action="/cities/{{ $city->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('city')]) }}')">{{ __('Delete') }}</button>
                </form>
            @endif
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $city->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{!! $city->name_pt ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{!! $city->name_ar ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $city->status ? __('Active') : __('Inactive') }}</td>
            </tr>
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $city->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $city->updated_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection
