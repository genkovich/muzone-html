import '@popperjs/core';
import 'bootstrap/dist/js/bootstrap.bundle';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import toastr from 'toastr';
toastr.options = {
    'progressBar': true,
    'positionClass': 'toast-custom'
};

const imagesContext = require.context('./admin/img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
const images = imagesContext.keys().reduce((images, key) => {
    images[key.replace('./', '')] = imagesContext(key);
    return images;
}, {});

window.images = images;

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $('.clickable-row').click(function() {
        window.location = $(this).data('href');
    });

    const $editable = $('.editable');
    $editable.each(function() {
        const fieldText = $(this);
        const iconEdit = $('<i class="bi bi-pencil-square ms-2 edit-icon"></i>');
        const fieldInput = $('<input>', {
            type: 'text',
            class: 'form-control field-input input-sm',
            style: 'display: none;',
            value: fieldText.text()
        }).wrap('<div class="col-lg-8"></div>').parent();

        const saveBtn = $('<button>', {
            class: 'btn btn-success btn-sm save-btn me-2',
            style: 'display: none;'
        }).append($('<i>', {class: 'bi bi-save'}));

        const cancelBtn = $('<button>', {
            class: 'btn btn-primary btn-sm cancel-btn me-2',
            style: 'display: none;'
        }).append($('<i>', {class: 'bi bi-x'}));

        const buttonsWrapper = $('<div>').addClass('col-lg-2').append(saveBtn, cancelBtn);
        const wrapper = $('<div>').addClass('row').addClass('align-items-center').append(fieldInput, buttonsWrapper);
        fieldText.after(iconEdit, wrapper);
    });

    $('.save-btn').click(function () {
        const fieldWrapper = $(this).closest('.editable-row');
        const fieldValue = fieldWrapper.find('.editable');
        const fieldInput = fieldWrapper.find('.field-input');
        const saveBtn = fieldWrapper.find('.save-btn');
        const cancelBtn = fieldWrapper.find('.cancel-btn');
        const editIcon = fieldWrapper.find('.edit-icon');

        // Здесь вы можете добавить код для сохранения изменений пользователя
        fieldValue.text(fieldInput.val());

        const value = fieldInput.val();
        const fieldName = fieldValue.data('field');
        const userId = fieldValue.data('user-id');

        $.ajax({
            url: `/admin/users/{id}/update-fields`,
            params: {
                id: userId
            },
            method: 'POST',
            data: {
                user_id: userId,
                field: fieldName,
                value: value,
            },
            success: function () {
                toastr.success('Данные успешно сохранены');
            },
            error: function () {
                toastr.error('Ошибка при сохранении данных');
            }
        });


        fieldValue.show();
        fieldInput.hide();
        saveBtn.hide();
        cancelBtn.hide();
        editIcon.show();
        console.log(`Field name: ${fieldName}, Field value: ${value}`);
    });


    $('.cancel-btn').click(function () {
        const fieldWrapper = $(this).closest('.editable-row');
        const fieldValue = fieldWrapper.find('.editable');
        const fieldInput = fieldWrapper.find('.field-input');
        const saveBtn = fieldWrapper.find('.save-btn');
        const cancelBtn = fieldWrapper.find('.cancel-btn');
        const editIcon = fieldWrapper.find('.edit-icon');

        fieldInput.val(fieldValue.text());

        fieldValue.show();
        fieldInput.hide();
        saveBtn.hide();
        cancelBtn.hide();
        editIcon.show();
    });

    $('.edit-icon').click(function () {
        const fieldWrapper = $(this).closest('.editable-row');
        const fieldValue = fieldWrapper.find('.editable');
        const fieldInput = fieldWrapper.find('.field-input');
        const saveBtn = fieldWrapper.find('.save-btn');
        const cancelBtn = fieldWrapper.find('.cancel-btn');
        const editIcon = fieldWrapper.find('.edit-icon');

        fieldValue.hide();
        fieldInput.show();
        saveBtn.show();
        cancelBtn.show();
        editIcon.hide();
    });




    const $sidebar = $('#sidebar');
    $('.toggle-sidebar').click(function () {
        $sidebar.toggleClass('collapsed');
        let sidebarState = $sidebar.hasClass('collapsed') ? 'collapsed' : 'expanded';

        $.ajax({
            url: `/admin/set-sidebar-state`,
            method: 'POST',
            data: {
                sidebar_state: sidebarState,
            },
            success: function () {
                console.log('Sidebar state updated');
            },
        });
    });



});