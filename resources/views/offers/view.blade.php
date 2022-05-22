@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex">
        <h2>{{ __('Offer Details') }}</h2>
        <div class="ms-auto d-flex align-items-center">
            @if ($offer->user_id == auth()->id())
                <a class="btn btn-primary mx-1" href="/offers/{{ $offer->id }}/edit">{{ __('Edit') }}</a>
                <a class="btn btn-danger mx-1" href=""
                    onclick="event.preventDefault();confirm('Are you sure you want to delete this offre?') ? document.querySelector('#form-delete').submit() : '';">{{ __('Delete') }}</a>
                <form id="form-delete" action="/offers/{{ $offer->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
            <a id="btn-approve" class="btn btn-primary mx-1" href="">{{ __('Approve') }}</a>

            <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#reject-modal">
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

            <script>
                $('#btn-approve').click(function() {
                    event.preventDefault();
                    if (confirm('Are you sure you want to reject this offer? that will post it in mobile app.')) {
                        $('input[name="result"]').val('approve')
                        document.querySelector('#form-review').submit();
                    }
                });
            </script>

        </div>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Titile') }}</td>
                <td>{{ $offer->title }}</td>
            </tr>
            <tr>
                <td>{{ __('Expiry Date') }}</td>
                <td>{{ $offer->expiry_date }}</td>
            </tr>
            <tr>
                <td>{{ __('Price') }}</td>
                <td>{{ $offer->price }}</td>
            </tr>
            <tr>
                <td>{{ __('Offer Type') }}</td>
                <td>{!! $offer->offerType->name_en !!}</td>
            </tr>
            <tr>
                <td>{{ __('Category') }}</td>
                <td>{!! $offer->category->name_en !!}</td>
            </tr>
            <tr>
                <td>{{ __('User') }}</td>
                <td>{!! $offer->user->name ?? '<em class="text-danger">Not Set</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $offer->status }}</td>
            </tr>
            @if ($offer->reject_reason)
                <tr>
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
                    <td>{{ $offer->user->name }}</td>
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
                <td>{!! $offer->description !!}</td>
            </tr>
            <tr>
                <td>{{ __('Tags') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @forelse ($offer->tags as $i => $tags)
                            {{ $tags->name . ($i + 1 != count($offer->tags) ? ',' : '') }}
                        @empty
                            <em class="text-danger">Not Set</em>
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('Target Areas') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @forelse ($offer->targetAreas as $i => $target)
                            {{ $target->name_en . ($i + 1 != count($offer->targetAreas) ? ',' : '') }}
                        @empty
                            <em class="text-danger">Not Set</em>
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">{{ __('Images') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @forelse ($offer->images as $image)
                            <img src="{{ asset('uploaded_images') . '/' . $image->name }}" class="my-2" alt=""
                                width="200">
                        @empty
                            <em class="text-danger">Not Set</em>
                        @endforelse
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
