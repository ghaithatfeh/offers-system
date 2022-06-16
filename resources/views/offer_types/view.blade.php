@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex justify-content-between">
        <h2>{{ __('Offer Type Details') }}</h2>
        <div>
            <a href="/offer_types/{{ $offer_type->id }}/edit" class="btn btn-primary">{{ __('Edit') }}</a>
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $offer_type->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{!! $offer_type->name_pt ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{!! $offer_type->name_ar ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Price') }}</td>
                <td>{{ $offer_type->price . ' ' . __('validation.currency')}}</td>
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
                <td>{{ __('Description') }}</td>
                <td class="pr-4 text-break w-50">{{ $offer_type->description }}</td>
            </tr>
        </tbody>
    </table>
@endsection
