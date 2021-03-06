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
                <td>{{ __($customer->gender) }}</td>
            </tr>
            <tr>
                <td>{{ __('Phone Number') }}</td>
                <td>
                    @if ($customer->phone != '')
                        {{ $customer->phone }}
                    @else
                        <em class="text-danger"> {{ __('Not Set') }} </em>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ __('Email') }}</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td>{{ $customer->status ? __('Active') : __('Inactive') }}</td>
            </tr>
            <tr>
                <td>{{ __('City') }}</td>
                <td>{{ $customer->city['name_' . App::getLocale()] }}</td>
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
                <td>{{ __('Interest Categories') }}</td>
                <td>
                    <div class="mx-auto">
                        @forelse ($interested_categories as $i => $interested_category)
                            {{ $interested_category->name }}
                            @if ($i + 1 != count($interested_categories))
                                <br>
                            @endif
                        @empty
                            <em class="text-danger">{{ __('Not Set') }}</em>
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('Subscriptions') }}</td>
                <td>
                    <div class="mx-auto">
                        @forelse ($customer->stores as $i => $store)
                            {{ $store->title }}
                            @if ($i + 1 != count($customer->stores))
                                <br>
                            @endif
                        @empty
                            <em class="text-danger">{{ __('Not Set') }}</em>
                        @endforelse
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
