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