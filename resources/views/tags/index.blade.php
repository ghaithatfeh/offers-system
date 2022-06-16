@extends('layouts.app')

@section('content')
    {{-- {{ Breadcrumbs::render('tags') }} --}}
    <h2 class="">{{ __('Tags') }}</h2>
    <div class="d-flex mt-4">
        <a href="/tags/create" class="btn btn-success text-nowrap me-3">{{ __('Add Tag') }}</a>

        <form action="/tags/search" method="GET" class="ms-auto">
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
                <th>{{ __('Name') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                @foreach ($tags as $i => $tag)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>
                            <a href="/tags/{{ $tag->id }}/edit" title="{{ __('Edit') }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if (!json_decode($tag->children))
                                <form class="d-inline-block" method="POST" action="/tags/{{ $tag->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-0 bg-transparent text-danger px-0" title="{{ __('Delete') }}"
                                        type="submit"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('tag')]) }}')">
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
    {{ $tags->appends(Request::except('page'))->links() }}
@endsection
