const equipmentSlider = new Swiper('.equipment__slider', {
    thumbs: {
        swiper: {
            el: '.equipment-mini',
            slidesPerView: 1.5,
            width: 217 * 1.5,
            spaceBetween: 30,

            breakpoints: {
                510: {
                    slidesPerView: 2,
                    width: 217 * 2.2,
                },
                768: {
                    slidesPerView: 2,
                    width: 360 * 2,
                },
                992: {
                    slidesPerView: 2,
                    width: 360 * 2 + 60,
                },
            }
        }
    },
});

//========
const teachersSlider = new Swiper('.teachers-slider', {
    thumbs: {
        swiper: {
            el: '.teachers-mini',
            slidesPerView: 2.5,
            width: 90 * 2.5 + 60,
            spaceBetween: 30,

            breakpoints: {
                510: {
                    slidesPerView: 3,
                    width: 94 * 3 + 60,
                },
                768: {
                    slidesPerView: 4,
                    width: 123 * 3 + 210,
                },
                992: {
                    slidesPerView: 6,
                    width: 123 * 6 + 150,
                },
            }
        }
    },

    navigation: {
        nextEl: '.rightArrow',
        prevEl: '.leftArrow',
    },
});

//=========
const feedbackSlider = new Swiper('.feedback-slider', {
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        prevEl: '.swiper-button-prev',
        nextEl: '.swiper-button-next'
    },
    slidesPerView: 1,
    width: 220,

    breakpoints: {
        582: {
            slidesPerView: 2,
            width: 300 * 1.6,
        },
        768: {
            slidesPerView: 1.2,
            width: 433 * 1.2,
        },
        992: {
            slidesPerView: 2,
            width: 433 * 2.1,
        }
    },
    spaceBetween: 54,
});

const educationSlider = new Swiper('.education-slider', {
    thumbs: {
        swiper: {
            el: '.education-mini',
            slidesPerView: 5,
            width: 134 * 2,
            breakpoints: {
                480: {
                    width: 134 * 2.5,
                },
                992: {
                    spaceBetween: 24,
                }
            },
        }
    }
});
//=======================
const questions = document.querySelectorAll('.item-faq');
if (questions.length > 0) {
    questions.forEach(function (item) {
        item.addEventListener('click', function () {
            item.classList.toggle('_active');
        });
    });
};

const stages = document.querySelectorAll('.education__stage');
if (stages.length > 0) {
    stages.forEach(function (item) {
        item.addEventListener('click', function () {
            item.classList.toggle('_active');
        });
    });
};