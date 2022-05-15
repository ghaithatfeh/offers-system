@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <h2 class="text-center">{{ __('Offer Details') }}</h2>

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
                <td>{!! $offer->user->name !!}</td>
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
                        @foreach ($offer->tags as $i => $tags)
                            {{ $tags->name . ($i + 1 != count($offer->tags) ? ',' : '') }}
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('Target Areas') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @foreach ($offer->targetAreas as $i => $target)
                            {{ $target->name_en . ($i + 1 != count($offer->targetAreas) ? ',' : '') }}
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('Images') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @foreach ($offer->images as $image)
                            <img src="{{ asset('uploaded_images') . '/' . $image->name }}" class="my-2" alt="" width="300">
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
