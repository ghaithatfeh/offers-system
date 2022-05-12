@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <h2 class="text-center">{{ __('Category Details') }}</h2>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $category->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{{ $category->name_pt }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{{ $category->name_ar }}</td>
            </tr>
            <tr>
                <td>{{ __('Parent Category') }}</td>
                <td>{!! $category->parent->name_en ?? '<em class="text-danger">Not Set</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
            </tr>
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $category->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $category->updated_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection
