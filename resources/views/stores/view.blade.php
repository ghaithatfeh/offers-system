@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex">
        <h2>{{ __('Store Details') }}</h2>
        <div class="ms-auto d-flex align-items-center">
            <a class="btn btn-primary mx-1" href="/stores/{{ $store->id }}/edit">{{ __('Edit') }}</a>
            <a class="btn btn-danger mx-1" href=""
                onclick="event.preventDefault();confirm('Are you sure you want to delete this store and his owner account?') ? document.querySelector('#form-delete').submit() : '';">{{ __('Delete') }}</a>
            <form id="form-delete" action="/stores/{{ $store->id }}" method="post">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Store Owner') }}</td>
                <td><a href="/users/{{ $store->user->id }}">{{ $store->user->name }}</a></td>
            </tr>
            <tr>
                <td>{{ __('Store Name') }}</td>
                <td>{{ $store->name }}</td>
            </tr>
            <tr>
                <td>{{ __('City') }}</td>
                <td>{{ $store->city->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Expiry Date') }}</td>
                <td>{{ $store->expiry_date }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $store->status }}</td>
            </tr>
            <tr>
                <td>{{ __('Description') }}</td>
                <td style="width: 80%" class="px-3">{!! $store->description !!}</td>
            </tr>
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $store->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $store->updated_at }}</td>
            </tr>
            <tr>
                <td class="align-middle">{{ __('Logo Image') }}</td>
                <td class="d-flex flex-column align-items-center">
                    @if ($store->logo)
                        <img class="my-2" width="100" src="{{ asset('uploaded_images/' . $store->logo) }}"
                            alt="">
                    @endif
                    <a href="/stores/upload/logo/{{ $store->id }}" class="btn-sm btn-success">{{__('Upload New Logo')}}</a>
                </td>
            </tr>
            <tr>
                <td class="align-middle">{{ __('Cover Image') }}</td>
                <td class="d-flex flex-column align-items-center">
                    @if ($store->cover)
                        <img class="my-2" width="100" src="{{ asset('uploaded_images/' . $store->cover) }}" alt="">
                    @endif
                    <a href="/stores/upload/cover/{{ $store->id }}" class="btn-sm btn-success">{{__('Upload New Cover')}}</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
