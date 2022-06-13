@extends('layouts.app')

@section('content')
    <h2 class="mb-3">{{ __('Categories') }}</h2>
    <div class="alert alert-warning">
        {{__('NOTE: You can\'t delete a category if it has children categories or offers releted to it, you can deactivate it.')}}<br>
        {{__('Inactive category (and its children and offers) won’t be displayed in mobile application.')}}
    </div>
    <div class="d-flex mt-1">
        <a href="/categories/create" class="btn btn-success">{{ __('Add Category') }}</a>
        <form action="/categories/search" method="GET" class="ms-auto">
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
            <th>{{ __('Parent Category') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name_en }}</td>
                    <td>{!! $category->name_pt ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>{!! $category->name_ar ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>{!! $category->parent->name_en ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input onchange="window.location.href = '/categories/change-status/{{ $category->id }}'" class="form-check-input" type="checkbox" id="toggle-{{$category->id}}" {{ $category->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="toggle-{{$category->id}}">{{ $category->status ? 'Active' : 'Inactive' }}</label>
                        </div>
                    </td>
                    <td>
                        <a href="/categories/{{ $category->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/categories/{{ $category->id }}/edit" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if (!json_decode($category->children) && !json_decode($category->offers))
                            <form class="d-inline-block" method="POST" action="/categories/{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->appends(Request::except('page'))->links() }}
@endsection
