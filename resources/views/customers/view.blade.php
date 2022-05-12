@extends('layouts.app')

@section('content')
    <style>
        td:first-child {
            font-weight: bold;
        }

    </style>
    <h2 class="text-center">{{ __('Customer Details') }}</h2>

    <table class="table text-center mt-4">
        <tbody>
            <tr>
                <td>{{ __('First Name') }}</td>
                <td>{{ $customer->first_name }}</td>
            </tr>
            <tr>
                <td>{{ __('Last Name') }}</td>
                <td>{{ $customer->last_name }}</td>
            </tr>
            <tr>
                <td>{{ __('Gender') }}</td>
                <td>{{ $customer->gender }}</td>
            </tr>
            </tr>
            <tr>
                <td>{{ __('Phone Number') }}</td>
                <td>{!! $customer->phone ?? '<em class="text-danger">Not Set</em>' !!}</td>
            </tr>
            <tr>
                <td>{{ __('Email') }}</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $customer->status ? 'Active' : 'Inactive' }}</td>
            </tr>
            <tr>
                <td>{{ __('City') }}</td>
                <td>{{ $customer->city->name_en }}</td>
            </tr>
            <tr>
                <td>{{ __('Registration Date') }}</td>
                <td>{{ $customer->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Last Update') }}</td>
                <td>{{ $customer->updated_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Interested Category') }}</td>
                <td>
                    <div class="mx-auto" style="width: 500px">
                        @foreach ($customer->customers_interests as $i => $interested_category)
                            {{ $interested_category->name_en . ($i + 1 != count($customer->customers_interests) ? ',' : '') }}
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
