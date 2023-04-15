import 'bootstrap/dist/js/bootstrap.bundle';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

const imagesContext = require.context('./admin/img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
const images = imagesContext.keys().reduce((images, key) => {
    images[key.replace('./', '')] = imagesContext(key);
    return images;
}, {});

window.images = images;

$(document).ready(function() {
    $('.toggle-sidebar').click(function() {
        console.log('click')
        $('#sidebar').toggleClass('collapsed');
    });
});