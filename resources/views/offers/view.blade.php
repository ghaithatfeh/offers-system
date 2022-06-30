@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

        .btn:not(.btn-sidebar) {
            width: 84px;
        }
    </style>
    <div class="d-flex">
        <h2>{{ __('Offer Details') }}</h2>
        <div class="ms-auto d-flex align-items-center">
            @if ($offer->status != 'Rejected' && auth()->user()->role != 'Store Owner')
                @if ($offer->status != 'Approved')
                    <a id="btn-approve" class="btn btn-success mx-1" href="">{{ __('Approve') }}</a>
                @endif
                <button type="button" class="btn btn-secondary mx-1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                    {{ __('Reject') }}
                </button>
                <!-- Modal -->
                <div class="modal fade" id="reject-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Reject Reason') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="form-review" action="/offers/{{ $offer->id }}/review" method="post">
                                <div class="modal-body">
                                    @csrf
                                    <input type="hidden" name="result" value="reject">
                                    <textarea class="form-control" name="reason" cols="30" rows="10"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if ($offer->user_id == auth()->id())
                <a class="btn btn-primary mx-1" href="/offers/{{ $offer->id }}/edit">{{ __('Edit') }}</a>
                <a class="btn btn-danger mx-1" href=""
                    onclick="event.preventDefault();confirm('{{ __('Are you sure you want to delete this :item?', ['item' => __('offer')]) }}') ? document.querySelector('#form-delete').submit() : '';">{{ __('Delete') }}</a>
                <form id="form-delete" action="/offers/{{ $offer->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Titile') }}</td>
                <td>{{ $offer->title }}</td>
            </tr>
            <tr>
                <th>{{ __('Offer Owner') }}</th>
                @if (auth()->user()->role != 'Store Owner')
                    <td>
                        <a
                            href="/{{ isset($offer->user) ? ($offer->user->store ? 'stores/' . $offer->user->store->id : 'users/' . $offer->user->id) : 'customers/' . $offer->customer->id }}">
                            {{ isset($offer->user) ? ($offer->user->store ? $offer->user->store->name : $offer->user->name) : $offer->customer->first_name . $offer->customer->last_name }}
                        </a>
                    </td>
                @endif
            </tr>
            <tr>
                <td>{{ __('Expiry Date') }}</td>
                <td>{!! $offer->expiry_date ?? '<em class="text-danger">' . __('Not Set') . '</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Price') }}</td>
                <td>{{ $offer->price . ' ' . __('validation.currency') }}</td>
            </tr>
            <tr>
                <td>{{ __('Offer Type') }}</td>
                <td>{{ $offer->offerType->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Category') }}</td>
                <td>{{ $offer->category['name_' . App::getLocale()] }}</td>
            </tr>
            <tr>
                <td>{{ isset($offer->user) ? __('User') : __('Customer') }}</td>
                <td>{{ $offer->user->name ?? $offer->customer->name }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
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
            </tr>
            @if ($offer->reject_reason)
                <tr class="text-danger">
                    <td>{{ __('Reject Reason') }}</td>
                    <td>{{ $offer->reject_reason }}</td>
                </tr>
            @endif
            @if ($offer->reviewed_by)
                <tr>
                    <td>{{ __('Reviewed At') }}</td>
                    <td>{{ $offer->reviewed_at }}</td>
                </tr>
                <tr>
                    <td>{{ __('Reviewed By') }}</td>
                    <td>{{ $offer->reviewedBy->name }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ __('Created At') }}</td>
                <td>{{ $offer->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated At') }}</td>
                <td>{{ $offer->updated_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Description') }}</td>
                <td class="pr-4 text-break w-50">
                    {{ $offer->description }}
                </td>
            </tr>
            <tr>
                <td>{{ __('Tags') }}</td>
                <td>
                    <div class="mx-auto">
                        @forelse ($offer->tags as $i => $tags)
                            {{ $tags->name }}
                            @if ($i + 1 != count($offer->targetAreas))
                                <br>
                            @endif
                        @empty
                            <em class="text-danger">{{ __('Not Set') }}</em>
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('Target Areas') }}</td>
                <td>
                    <div class="mx-auto">
                        @forelse ($offer->targetAreas as $i => $target)
                            {{ $target['name_' . App::getLocale()] }}
                            @if ($i + 1 != count($offer->targetAreas))
                                <br>
                            @endif
                        @empty
                            <em class="text-danger">{{ __('Not Set') }}</em>
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">{{ __('Images') }}</td>
                <td>
                    <div class="row mx-auto">
                        @forelse ($offer->images as $image)
                            <div class="col-6 mx-auto">
                                <img src="{{ asset('uploaded_images') . '/' . $image->name }}" class="my-2 img-fluid"
                                    alt="" width="">
                            </div>
                        @empty
                            <em class="text-danger my-2">{{ __('Not Set') }}</em>
                        @endforelse
                    </div>
                    @if (auth()->id() == $offer->user_id)
                        <a href="/offers/upload/{{ $offer->id }}"
                            class="btn-sm btn-success mx-auto mt-2">{{ __('Upload Images') }}
                        </a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $('#btn-approve').click(function() {
            event.preventDefault();
            if (confirm(
                    '{{ __('Are you sure you want to approve this offer? that will post it in mobile app.') }}'
                )) {
                $('input[name="result"]').val('approve')
                document.querySelector('#form-review').submit();
            }
        });
    </script>
@endsection
