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
            <th>{{ __('#') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Target Type') }}</th>
            <th>{{ __('Sent At') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($notifications as $i => $notification)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $notification->title }}</td>
                    <td>{{ __($notification->target_type) }}</td>
                    <td>{{ $notification->created_at }}</td>
                    <td>
                        <a href="/notifications/{{ $notification->id }}" title="{{ __('View') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifications->appends(Request::except('page'))->links() }}
@endsection

@section('script')
    <script>
        window.onload = function() {
            setTimeout(function() {
                $(".alert").fadeOut()
            }, 3000)
        }
    </script>
@endsection
