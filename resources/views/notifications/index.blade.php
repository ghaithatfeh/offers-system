@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Notifications') }}</h2>
    <div class="d-flex mt-4">
        <a href="/notifications/create" class="btn btn-success">{{ __('Send New Notification') }}</a>
    </div>

    <table class="table text-center mt-4">
        <thead>
            <th>{{ __('Id') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Target Type') }}</th>
            <th>{{ __('Target Value') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->id }}</td>
                    <td>{{ $notification->title }}</td>
                    <td>{{ $notification->target_type }}</td>
                    <td>{!! $notification->target_value ?? '<em class="text-danger">Not Set</em>' !!}</td>
                    <td>
                        <a href="/notifications/{{ $notification->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form class="d-inline-block" method="POST" action="/notifications/{{ $notification->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="border-0 bg-transparent text-danger px-0" title="Delete" type="submit"
                                onclick="return confirm('Are you sure you want to delete this notification?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifications->appends(Request::except('page'))->links() }}
@endsection
