@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex justify-content-between">
        <h2>{{ __('Category Details') }}</h2>
        <div>
            <a href="/categories/{{ $category->id }}/edit" class="btn btn-primary">{{ __('Edit') }}</a>
            @if (!json_decode($category->children))
                <form class="d-inline-block" action="/categories/{{ $category->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Are you sure you want to delete this category?')">{{ __('Delete') }}</button>
                </form>
            @endif
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Name English') }}</td>
                <td>{{ $category->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Name Portuguese') }}</td>
                <td>{!! $category->name_pt ?? '<em class="text-danger">Not Set</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>{!! $category->name_ar ?? '<em class="text-danger">Not Set</em>' !!}</td>
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
