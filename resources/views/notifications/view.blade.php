@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <div class="d-flex justify-content-between">
        <h2>{{ __('Notification Details') }}</h2>
    </div>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('Titile') }}</td>
                <td>{{ $notification->title }}</td>
            </tr>
            <tr>
                <td>{{ __('body') }}</td>
                <td style="width: 82%">{{ $notification->body }}</td>
            </tr>
            <tr>
                <td>{{ __('Target Type') }}</td>
                <td>{{ $notification->target_type }}</td>
            </tr>
            @if ($notification->target_type != 'Broadcast')
                <tr>
                    <td>{{ __('Target Value') }}</td>
                    <td>{{ $notification->target_value }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ __('Sent At') }}</td>
                <td>{{ $notification->created_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection
