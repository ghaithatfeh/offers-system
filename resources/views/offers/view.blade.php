@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex justify-content-between">
        <h2>{{ __('Offer Details') }}</h2>
        @if ($offer->user_id == auth()->id())
            <div>
                <a href="/offers/{{ $offer->id }}/edit" class="btn btn-primary">{{ __('Edit') }}</a>
                <a class="btn btn-danger" href=""
                    onclick="event.preventDefault();document.querySelector('#form-delete').submit();">{{ __('Delete') }}</a>
                <form id="form-delete" action="/offers/{{ $offer->id }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endif
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
                <td>{{ __('Images') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @forelse ($offer->images as $image)
                            <img src="{{ asset('uploaded_images') . '/' . $image->name }}" class="my-2" alt=""
                                width="300">
                        @empty
                            <em class="text-danger">Not Set</em>
                        @endforelse
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
