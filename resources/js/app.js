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

$('#target_type').change(function (e) {
    $('.loading').removeClass('d-none')
    switch ($(this).val()) {
        case "Broadcast":
            $('#target_value').html('');
            $('#target_value').parent().addClass('d-none')
            break;
        case "Gender":
            var data = [{
                id: "Male",
                text: "Male"
            },
            {
                id: "Female",
                text: "Female"
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
                    console.log(data);
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