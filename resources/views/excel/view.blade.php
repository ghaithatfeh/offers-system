@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h2 class="">{{ __('Offers By Excel File: ') . $excel_file->name }}</h2>
        <a href="" class="btn btn-danger w-auto">{{ __('Delete the file and all its offers') }}</a>
    </div>
    <h5>{{ __('Uploaded At: ') . $excel_file->created_at }}</h5>

    <table class="table table-borderd text-center mt-4">
        <thead>
            <th>{{ __('Id') }}</th>
            <th>{{ __('Titile') }}</th>
            <th>{{ __('Expiry Date') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr>
                    <td>{{ $offer->id }}</td>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->expiry_date }}</td>
                    <td>{{ $offer->price . ' ' . __('validation.currency') }}</td>
                    <td>
                        {{ $offer->status }}
                        @if ($offer->status == 'On Hold')
                            <i class="fa-solid fa-circle-question text-warning"></i>
                        @elseif ($offer->status == 'Approved')
                            <i class="fa-solid fa-circle-check text-success"></i>
                        @else
                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                        @endif
                    </td>
                    <td>
                        <a href="/offers/{{ $offer->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if ($offer->user_id == auth()->id())
                            <a href="/offers/{{ $offer->id }}/edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form class="d-inline-block" method="POST" action="/offers/{{ $offer->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this offer type?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $offers->appends(Request::except('page'))->links() }}
@endsection
