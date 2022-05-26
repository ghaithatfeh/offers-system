@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Notifications') }}</h2>
    @if (Session::has('notify-message'))
        <div class="alert {{ session('notify-alert') }}">{{ session('notify-message') }}</div>
    @endif
    <div class="d-flex mt-4">
        <a href="/notifications/create" class="btn btn-success">{{ __('Send New Notification') }}</a>
    </div>

    <table class="table text-center mt-4">
        <thead>
            <th>{{ __('Id') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Target Type') }}</th>
            <th>{{ __('Sent At') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->id }}</td>
                    <td>{{ $notification->title }}</td>
                    <td>{{ $notification->target_type }}</td>
                    <td>{{ $notification->created_at }}</td>
                    <td>
                        <a href="/notifications/{{ $notification->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifications->appends(Request::except('page'))->links() }}
@endsection
