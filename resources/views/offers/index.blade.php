@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Offers') }}</h2>
    <div class="d-flex mt-4">
        <a href="/offers/create" class="btn btn-success text-nowrap me-3">{{ __('Add Offer') }}</a>
        @if (auth()->user()->role == 'Store Owner')
            <a href="/bulk-offers/import-from-excel" class="btn btn-primary ms-2">{{ __('Import From Excel') }}</a>
        @endif
        <form action="/offer/search" method="GET" class="ms-auto">
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
        <table class="table table-borderd text-center mt-4">
            <thead>
                <th>{{ __('#') }}</th>
                <th>{{ __('Titile') }}</th>
                <th>{{ __('Offer Owner') }}</th>
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
                        <td>
                            <a
                                href="/{{ isset($offer->user) ? 'users/' . $offer->user->id : 'customers/' . $offer->customer->id }}">
                                {{ $offer->user->name ?? $offer->customer->first_name . $offer->customer->last_name }}
                            </a>
                        </td>
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
                                    <button class="border-0 bg-transparent text-danger px-0" title="{{ __('Delete') }}"
                                        type="submit"
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
@endsection
