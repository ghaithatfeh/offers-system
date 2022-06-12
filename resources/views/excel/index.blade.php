@extends('layouts.app')

@section('content')
    <h2 class="">{{ __('Excile Files') }}</h2>
    <div class="d-flex mt-4">
        <a href="/bulk-offers/import-from-excel" class="btn btn-primary ms-2">{{ __('Import From Excel') }}</a>
        <form action="/offer/search" method="GET" class="ms-auto">
            <div class="input-group">
                <div class="form-outline">
                    <input name="search" type="search" id="form1" class="form-control"
                        placeholder="{{ __('Search here') }}.." value="{{ $_GET['search'] ?? '' }}" />
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <table class="table table-borderd text-center mt-4">
        <thead>
            <th>{{ __('Id') }}</th>
            <th>{{ __('File Name') }}</th>
            <th>{{ __('Number Of Offers') }}</th>
            <th>{{ __('Uploaded At') }}</th>
            <th>{{ __('Actions') }}</th>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td class="">{{ $file->name }}</td>
                    <td>{{ count($file->offers) }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td>
                        <a href="{{ asset('uploaded_images/excel_files/' . $file->name) }}" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="/bulk-offers/{{ $file->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $files->appends(Request::except('page'))->links() }}
@endsection
