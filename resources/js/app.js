require('./bootstrap');
require('select2');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'admin-lte/plugins/select2/js/select2.full.min.js';

$('.select2').select2({
    placeholder: '',
    allowClear: true,
    closeOnSelect: false,
    debug: true
})

var url = window.location.toString()

if (url.includes('notifications/create'))
    targetTypeChange.apply($('#target_type'));

$('#target_type').change(targetTypeChange);

function targetTypeChange() {
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
                function (data) {
                    select2(data);
                });
    }
}

function select2(data = []) {
    $('.loading').addClass('d-none')
    $('#target_value').select2({
        data: data,
        debug: true,
        closeOnSelect: false,
    });
}