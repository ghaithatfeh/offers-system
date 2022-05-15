@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <h2 class="text-center">{{ __('Offer Type Details') }}</h2>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $offer_type->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{{ $offer_type->name_pt }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{{ $offer_type->name_ar }}</td>
            </tr>
            <tr>
                <td>{{ __('Price') }}</td>
                <td>{{ $offer_type->price }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $offer_type->status ? 'Active' : 'Inactive' }}</td>
            </tr>
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $offer_type->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $offer_type->updated_at }}</td>
            </tr>
            <tr>
                <td class="mx-auto" style="width: 500px">{{ __('Description') }}</td>
                <td>{{ $offer_type->description }}</td>
            </tr>
        </tbody>
    </table>
@endsection
