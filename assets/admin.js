import 'bootstrap/dist/js/bootstrap.bundle';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

$(document).ready(function() {
    $('.toggle-sidebar').click(function() {
        console.log('click')
        $('#sidebar').toggleClass('collapsed');
    });
});