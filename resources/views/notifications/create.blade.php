@extends('layouts.app')

@section('content')
    <h2 class="text-center">{{ __('Send New Notification') }}</h2>
    <form action="/notifications" method="post" class="mt-4 col-12 col-md-8 col-lg-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">{{ __('Notification Title') }}</label>
            <input id="title" name="title" class="form-control" type="text">
        </div>
        <div class="mb-3">
            <label class="form-label" for="body">{{ __('Notification Message') }}</label>
            <textarea id="body" name="body" class="form-control" cols="30" rows="10"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="target_type">{{ __('Target Type') }}</label>
            <select id="target_type" name="target_type" class="form-control">
                @php
                    $target_types = ['Broadcast', 'Categories', 'Cities', 'Gender'];
                @endphp
                @foreach ($target_types as $target_type)
                    <option value="{{ $target_type }}">
                        {{ __($target_type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 d-none">
            <label class="form-label" for="target_value">{{ __('Target Value') }}</label>
            <img class="loading col-1" src="{{ asset('images/loading.gif') }}" alt="">
            <select id="target_value" name="target_value[]" class="form-control multiple" multiple="multiple">
            </select>
        </div>
        <div class="d-flex">
            <button type="submit"
                onclick="return confirm('{{ __('Are you sure you want to send this notification?') }}')"
                class="btn btn-success mx-auto">{{ __('Send') }}</button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $('#target_type').change(function() {
            $('.loading').removeClass('d-none')
            switch ($(this).val()) {
                case "Broadcast":
                    $('#target_value').html('');
                    $('#target_value').parent().addClass('d-none')
                    break;
                case "Gender":
                    $('#target_value').html('');
                    $('#target_value').parent().removeClass('d-none')
                    var data = [{
                            id: "Male",
                            text: male
                        },
                        {
                            id: "Female",
                            text: female
                        },
                    ];
                    select2(data);
                    break;
                default:
                    $('#target_value').html('');
                    $('#target_value').parent().removeClass('d-none')
                    $.get("/notification/get-options", {
                            type: $(this).val()
                        },
                        function(data) {
                            select2(data);
                        });
            }
        });

        function select2(data = []) {
            $('.loading').addClass('d-none')
            $('#target_value').select2({
                data: data,
                debug: true,
                closeOnSelect: false,
            });
        }
    </script>

    {{-- Validation --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\NotificationRequest') !!}
@endsection
