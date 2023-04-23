import toastr from 'toastr';

toastr.options = {
    'progressBar': true,
    'positionClass': 'toast-bottom-full-width',
};

jQuery.validator.addMethod("telegram", function (value, element) {
    const telegramPattern = /^@?[a-zA-Z0-9_\/:\.-]{4,32}$/;
    return this.optional(element) || telegramPattern.test(value);
}, "Будь ласка, перевірте правильність telegram нікнейму");

jQuery.validator.addMethod("instagram", function (value, element) {
    var instagramPattern = /^[a-zA-Z0-9_\/:\.-]{4,32}$/;
    return this.optional(element) || instagramPattern.test(value);
}, "Будь ласка, перевірте правильність instagram нікнейму");

$(document).ready(function () {
    const contactForms = $('.j-form');

    contactForms.each(function () {
        const contactForm = $(this);

        contactForm.validate({
            rules: {
                your_phone: {
                    required: true,
                    minlength: 10,
                },
                your_telegram: {
                    required: true,
                    minlength: 4,
                    maxlength: 32,
                    telegram: true,
                },
                your_instagram: {
                    required: true,
                    minlength: 4,
                    maxlength: 30,
                    instagram: true,
                },
            },
            messages: {
                your_phone: {
                    required: "Будь ласка, введіть ваш номер телефону",
                    minlength: "Номер телефону має містити мінімум 10 символів",
                },
                your_telegram: {
                    required: "Будь ласка, введіть ваш нік Telegram",
                    minlength: "Нікнейм Telegram має містити мінімум 4 символи",
                    maxlength: "Нікнейм Telegram не повинен перевищувати 32 символи",
                    telegram: "Будь ласка, введіть коректний нікнейм Telegram",
                },
                your_instagram: {
                    required: "Будь ласка, введіть ваш нік Instagram",
                    minlength: "Нікнейм Instagram має містити мінімум 4 символи",
                    maxlength: "Нікнейм Instagram не повинен перевищувати 30 символів",
                    instagram: "Будь ласка, введіть коректний нікнейм Instagram",
                },
            },
        });

        contactForm.on('submit', async function (event) {
            event.preventDefault();

            const currentForm = $(this)

            // Проверка валидности формы
            if (!currentForm.valid()) {
                toastr.error('Будь ласка, перевірте що там введено', 'error');
                return;
            }

            $('button[type="submit"]', this).prop('disabled', true);

            const formData = currentForm.serialize();

            $.ajax({
                url: '/contact',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (jsonResponse) {
                    if (jsonResponse.success) {
                        toastr.success('Ми дуже скоро зв\`яжемось з вами', 'Дякуюємо за звернення!');

                        currentForm[0].reset(); // Сброс текущей формы
                    } else {
                        toastr.error('Будь ласка, спробуйте ще раз', 'Нажаль виникла помилка');
                    }

                    $('button[type="submit"]', currentForm).prop('disabled', false);
                },
                error: function (xhr, textStatus, errorThrown) {
                    toastr.error('Будь ласка, спробуйте ще раз', 'Нажаль виникла помилка');
                    $('button[type="submit"]', currentForm).prop('disabled', false);
                },
            });

        });
    });
});

$(document).ready(function () {
    $('[data-fancybox][data-src="#modal"]').on('click', function () {
        let direction = $(this).attr('data-direction');
        let directionTitle = $(this).attr('data-direction-title');

        let $form = $('#modal').find('form'); // Найдите форму внутри вызванного модального окна

        $form.find('input[name="direction_title"]').val(directionTitle); // Используйте найденную форму в качестве контекста для выборки инпутов
        $form.find('input[name="direction"]').val(direction);
    });

    $('[data-fancybox][data-src="#modal-prices"]').on('click', function () {
        let direction = $(this).attr('data-direction');
        let directionTitle = $(this).attr('data-direction-title');
        let age = $(this).attr('data-age');
        let groupType = $(this).attr('data-group-type');
        let count = $(this).attr('data-count');

        let $form = $('#modal-prices').find('form'); // Найдите форму внутри вызванного модального окна

        $form.find('input[name="direction_title"]').val(directionTitle); // Используйте найденную форму в качестве контекста для выборки инпутов
        $form.find('input[name="direction"]').val(direction);
        $form.find('input[name="age"]').val(age);
        $form.find('input[name="group_type"]').val(groupType);
        $form.find('input[name="count"]').val(count);
    });
});