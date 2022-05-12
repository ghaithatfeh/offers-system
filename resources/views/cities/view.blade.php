@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <h2 class="text-center">{{ __('City Details') }}</h2>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $city->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{{ $city->name_pt }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{{ $city->name_ar }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $city->status ? 'Active' : 'Inactive' }}</td>
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
