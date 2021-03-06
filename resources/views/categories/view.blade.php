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
            @if (!json_decode($category->children) && !json_decode($category->offers))
                <form class="d-inline-block" action="/categories/{{ $category->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('category')]) }}')">{{ __('Delete') }}</button>
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
                <td>
                    @if ($category->name_pt != '')
                        {{ $category->name_pt }}
                    @else
                        <em class="text-danger">{{ __('Not Set') }}</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ __('Name Arabic') }}</td>
                <td>
                    @if ($category->name_ar != '')
                        {{ $category->name_ar }}
                    @else
                        <em class="text-danger">{{ __('Not Set') }}</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ __('Parent Category') }}</td>
                <td>
                    @if (isset($category->parent))
                        {{ $category->parent->name_en }}
                    @else
                        <em class="text-danger">{{ __('Not Set') }}</em>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $category->status ? __('Active') : __('Inactive') }}</td>
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
