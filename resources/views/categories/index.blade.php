@extends('layouts.app')

@section('content')
    <h2 class="mb-3">{{ __('Categories') }}</h2>
    <div class="alert alert-warning">
        {{ __("NOTE: You can't delete a category if it has children categories or offers releted to it, you can deactivate it.") }}<br>
        {{ __('Inactive category (and its children and offers) won’t be displayed in mobile application.') }}
    </div>
    <div class="d-flex mt-1">
        <a href="/categories/create" class="btn btn-success text-nowrap me-3">{{ __('Add Category') }}</a>
        <form action="/categories/search" method="GET" class="ms-auto">
            <div class="input-group d-flex flex-nowrap">
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
    <div class="table-responsive">
        <table class="table text-center mt-4">
            <thead>
                <th>{{ __('#') }}</th>
                <th>{{ __('Name English') }}</th>
                <th>{{ __('Name Portuguese') }}</th>
                <th>{{ __('Name Arabic') }}</th>
                <th>{{ __('Parent Category') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                @foreach ($categories as $i => $category)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $category->name_en }}</td>
                        <td>{!! $category->name_pt ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
                        <td>{!! $category->name_ar ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
                        <td>{!! $category->parent->name_en ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input onchange="
                                    if (confirm('{{ __('Are you sure you want to change this status?') }}'))
                                        window.location.href = '/categories/change-status/{{ $category->id }}'
                                    else
                                        this.checked = !this.checked" class="form-check-input" type="checkbox"
                                    id="toggle-{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="toggle-{{ $category->id }}">{{ $category->status ? __('Active') : __('Inactive') }}</label>
                            </div>
                        </td>
                        <td>
                            <a href="/categories/{{ $category->id }}" title="{{ __('View') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/categories/{{ $category->id }}/edit" title="{{ __('Edit') }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if (!json_decode($category->children) && !json_decode($category->offers))
                                <form class="d-inline-block" method="POST" action="/categories/{{ $category->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-0 bg-transparent text-danger px-0" title="{{ __('Delete') }}"
                                        type="submit"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('category')]) }}')">
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
    {{ $categories->appends(Request::except('page'))->links() }}
@endsection
