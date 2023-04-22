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
    const contactForm = $('.j-form');

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
                required: "Будь ласка, введіть ваш номер телефону"  ,
                minlength: "Номер телефону має містити мінімум 10 символів",
            },
            your_telegram: {
                required: "Будь ласка, введіть ваш Telegram",
                minlength: "Нікнейм Telegram має містити мінімум 4 символи",
                maxlength: "Нікнейм Telegram не повинен перевищувати 32 символи",
                telegram: "Будь ласка, введіть коректний нікнейм Telegram",
            },
            your_instagram: {
                required: "Пожалуйста, введите ваш Instagram",
                minlength: "Instagram должен содержать минимум 1 символ",
                maxlength: "Instagram не должен превышать 30 символов",
                instagram: "Пожалуйста, введите корректный никнейм Instagram",
            },
        },
    });

    contactForm.on('submit', async function (event) {
        event.preventDefault();

        // Проверка валидности формы
        if (!contactForm.valid()) {
            toastr.error('Будь ласка, перевірте що там введено', 'error');
            return;
        }

        $('button[type="submit"]', this).prop('disabled', true);

        const formData = $(this).serialize();

        $.ajax({
            url: '/contact',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (jsonResponse) {
                if (jsonResponse.success) {
                    toastr.success('Ми дуже скоро зв\`яжемось з вами', 'Дякуюємо за звернення!');
                } else {
                    toastr.error('Будь ласка, спробуйте ще раз', 'Нажаль виникла помилка');
                }

                $('button[type="submit"]').prop('disabled', false);
            },
            error: function (xhr, textStatus, errorThrown) {
                toastr.error('Будь ласка, спробуйте ще раз', 'Нажаль виникла помилка');
                $('button[type="submit"]').prop('disabled', false);
            },
        });

    });
});