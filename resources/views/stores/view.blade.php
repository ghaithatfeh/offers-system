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
            <a class="btn btn-primary mx-1"
                href="{{ auth()->user()->role == 'Store Owner' ? '/my-store/edit' : '/stores/' . $store->id . '/edit' }}">{{ __('Edit') }}</a>
            @if (!$store->user->offers->count() && auth()->user()->role != 'Store Owner')
                <a class="btn btn-danger mx-1" href=""
                    onclick="event.preventDefault();confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('store')]) }}') ? document.querySelector('#form-delete').submit() : '';">{{ __('Delete') }}</a>
                <form id="form-delete" action="/stores/{{ $store->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Store Name') }}</td>
                <td>{{ $store->name }}</td>
            </tr>
            <tr>
                <td>{{ __('Store Owner') }}</td>
                <td>{{ $store->user->name }}</td>
            </tr>
            <tr>
                <td>{{ __('Email') }}</td>
                <td>{{ $store->user->email }}</td>
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
                <td>{{ __($store->status) }}</td>
            </tr>
            <tr>
                <td>{{ __('Description') }}</td>
                <td class="pr-4 text-break w-50">{!! $store->description !!}</td>
            </tr>
            <tr>
                <td>{{ __('Subscriptions') }}</td>
                <td>
                    {{ $store->customers->count() }}
                </td>
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
                        <div class="my-2">
                            <img width="150" src="{{ asset('uploaded_images/' . $store->logo) }}" alt="">
                            <form action="/stores/delete_image/logo/{{ $store->id }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger rounded-0 rounded-bottom w-100 p-0"
                                    onclick="return confirm('Are you sure you want to delete this image from your offer?')">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                    <a href="/stores/upload/logo/{{ $store->id }}"
                        class="btn-sm btn-success">{{ __('Upload New Logo') }}</a>
                </td>
            </tr>
            <tr>
                <td class="align-middle">{{ __('Cover Image') }}</td>
                <td class="d-flex flex-column align-items-center">
                    @if ($store->cover)
                        <div class="my-2">
                            <img width="150" src="{{ asset('uploaded_images/' . $store->cover) }}" alt="">
                            <form action="/stores/delete_image/cover/{{ $store->id }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger rounded-0 rounded-bottom w-100 p-0"
                                    onclick="return confirm('Are you sure you want to delete this image from your offer?')">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                    <a href="/stores/upload/cover/{{ $store->id }}"
                        class="btn-sm btn-success">{{ __('Upload New Cover') }}</a>
                </td>
            </tr>
        </tbody>
    </table>

    @if (auth()->user()->role != 'Store Owner')
        <h2 class="mt-3">{{ __('Store Offers') }}</h2>
        <div class="table-responsive">
            <table class="table table-borderd text-center mt-4">
                <thead>
                    <th>{{ __('#') }}</th>
                    <th>{{ __('Titile') }}</th>
                    <th>{{ __('Expiry Date') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </thead>
                <tbody>
                    @foreach ($offers as $i => $offer)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $offer->title }}</td>
                            <td>{!! $offer->expiry_date ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
                            <td>{{ $offer->price . ' ' . __('validation.currency') }}</td>
                            <td>
                                {{ __($offer->status) }}
                                @if ($offer->status == 'On Hold')
                                    <i class="fa-solid fa-circle-question text-warning"></i>
                                @elseif ($offer->status == 'Approved')
                                    <i class="fa-solid fa-circle-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <a href="/offers/{{ $offer->id }}" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($offer->user_id == auth()->id())
                                    <a href="/offers/{{ $offer->id }}/edit" title="{{ __('Edit') }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form class="d-inline-block" method="POST" action="/offers/{{ $offer->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="border-0 bg-transparent text-danger px-0"
                                            title="{{ __('Delete') }}" type="submit"
                                            onclick="return confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('offer')]) }}')">
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
        {{ $offers->appends(Request::except('page'))->links() }}
    @endif
@endsection
