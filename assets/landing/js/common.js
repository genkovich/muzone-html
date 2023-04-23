import svg4everybody from "svg4everybody";

export function commonInit($, svg4everybody, Fancybox, Swiper, gsap, Circ, Quad) {
	const $document = $(document),
		$window = $(window),
		$up = $('.j-up'),
		$header = $('.j-header'),
		$wrapper = $('.j-wrapper'),
		$overlay = $('.j-overlay');


	// support svg sprite-------------------------------
	svg4everybody();


	// header and up button-----------------------------
	function headerFixed() {
		let scroll = window.scrollY;

		if (scroll > 0) {
			$header.addClass('fixed');
		} else {
			$header.removeClass('fixed');
		}

		if (scroll > 1700) {
			$up.addClass('active');
		} else {
			$up.removeClass('active');
		}
	}

	$up.on('click', function () {
		gsap.to(window, {
			duration: 2,
			scrollTo: 0,
			ease: Circ.easeInOut,
		});
	});

	$window.on('scroll', function () {
		headerFixed();
	});

	headerFixed();

	window.onscroll = function (e) {
		if (this.scrollY > 300) {
			if (this.oldScroll < this.scrollY) {
				$header.addClass('down');
			} else {
				$header.removeClass('down');
			}
			this.oldScroll = this.scrollY;
		}
	}


	// fancybox---------------------------------------------------
	const opts_fancybox = {
		autoFocus: false,
		trapFocus: false,
		dragToClose: false,
		placeFocusBack: false,
		Thumbs: false,
		on: {
			reveal: function (fancybox, carousel) {
				let $slide = $(fancybox.$container),
					theme = carousel.theme;

				if ($slide.find('.j-wow-modal').length > 0) {
					$slide.find('.j-wow-modal').each(function () {
						animateFrom(this);
					});
				}

				$slide.find('.j-theme').val(theme);
			},
		}
	};
	Fancybox.bind('[data-fancybox]', opts_fancybox);
	$document.on('click', '[data-close]', function () {
		Fancybox.close();
	});


	// data-toggle-----------------------------------------
	$(function () {
		const btn = '[data-toggle]';

		$(btn).on('click', function (e) {
			e.preventDefault();

			let $this = $(this),
				target = $this.data('toggle');

			$(target).slideToggle(300, function () {
				ScrollTrigger.refresh();
			});
		});
	});


	// data-target-----------------------------------------
	$(function () {
		let btn = '[data-target]';

		$document.on('click', btn, function (e) {
			e.preventDefault();

			let $this = $(this),
				target = $this.attr('data-target'),
				$commonParent = $this.closest('.j-phone'); // Замените '.common-parent-class' на класс общего родителя

			$(btn).each(function () {
				let $this_new = $(this),
					target_new = $this_new.attr('data-target'),
					$target_new = $(target_new);

				if (target !== target_new && !$(target).parents().is('.active-target')) {
					$this_new.removeClass('active-target');
					$target_new.removeClass('active-target');
				}
			});

			$this.toggleClass('active-target');
			$commonParent.find(target).toggleClass('active-target'); // Используйте find() для поиска ближайшего элемента с атрибутом data-target
		});

		function hide_target() {
			$(btn).each(function () {
				let $this = $(this),
					target = $this.attr('data-target');

				$this.removeClass('active-target');
				$(target).removeClass('active-target');
			});
		}

		$document.on('click', function (e) {
			let $target = $(e.target);

			if (!$target.is(btn) &&
				!$target.parents().is(btn) &&
				!$target.is('.active-target') &&
				!$target.parents().is('.active-target')
			) {
				hide_target();
			}
		});

		$('.j-overlay').on('click', function () {
			hide_target();
		});
	});


	// scroll to element-----------------------------------------
	$(function () {
		let $link = $('.j-scroll');
		let ww = $window.width();


		$link.on('click', function (e) {
			e.preventDefault();

			let $this = $(this),
				href = $this.attr('href') || $this.data('scroll'),
				offset = $header.outerHeight(),
				ww = $window.width();

			gsap.to(window, {
				duration: 1.8,
				scrollTo: {
					y: href,
					offsetY: offset,
				},
				ease: Circ.easeInOut,
			});

			if (ww <= 1200) {
				$('.header__toggle').trigger('click');
			}
		});

		function onScroll() {
			let scroll_top = $window.scrollTop(),
				header_height = $header.outerHeight() + 20;

			$link.each(function () {
				let $this = $(this),
					href,
					bl;

				if ($this.is('[href]')) {
					href = $this.attr('href');
				} else {
					href = $this.data('scroll');
				}

				bl = $(href);

				if ($this.is(':visible') && bl.length > 0) {
					if (bl.offset().top <= scroll_top + header_height && bl.offset().top + bl.outerHeight() - header_height > scroll_top) {
						$link.removeClass('active');
						if ($this.is('[href]')) {
							$('.j-scroll[href="' + href + '"]').addClass('active');
						} else {
							$('.j-scroll[data-scroll="' + href + '"]').addClass('active');
						}
					} else {
						$this.removeClass('active');
					}
				}
			});
		}

		$document.on('scroll', onScroll);
	});


	// lazy-----------------------------------------
	$('.j-lazy').lazy({
		visibleOnly: true,
		afterLoad: function (item) {
			$(item).addClass('loaded');
		},
	});


	// slider-----------------------------------------
	$(function () {
		let $slider = $('.j-reviews-slider');

		new Swiper($slider.find('.reviews__slider')[0], {
			speed: 700,
			wrapperClass: 'reviews__slider-wrapper',
			slideClass: 'reviews__slider-slide',
			navigation: {
				nextEl: $slider.find('.j-next')[0],
				prevEl: $slider.find('.j-prev')[0],
			},
			breakpoints: {
				992: {
					slidesPerView: 3,
					spaceBetween: 24
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 24
				},
				0: {
					slidesPerView: 1,
					spaceBetween: 24
				},
			}
		});
	});


	// slider with resize-----------------------------------------
	$(function () {
		function slider_results() {
			var $slider = $('.j-results-slider');

			if ($window.width() <= 767) {
				if (!$slider.is('.swiper-initialized')) {
					new Swiper('.j-results-slider', {
						speed: 400,
						slidesPerView: 'auto',
						slideClass: 'results__table',
						wrapperClass: 'results__slider-wrapper',
						freeMode: true,
						scrollbar: {
							el: $slider.find('.j-scrollbar')[0],
							draggable: true,
						},
					});
				}
			} else {
				if ($slider.is('.swiper-initialized')) {
					$slider[0].swiper.destroy(true, true);
				}
			}
		}

		slider_results();

		$window.on('resize', slider_results);
	});


	// tabs---------------------------------------
	$('[data-tab]').on('click', function () {
		let $this = $(this),
			tab = $this.attr('data-tab'),
			$tab = $(tab);

		if (!$this.is('.active')) {
			$('[data-tab]').removeClass('active');
			$this.addClass('active');

			$('.j-tab-wrapper').hide();
			gsap.killTweensOf('.j-tab-wrapper');

			gsap.fromTo($tab[0], {
				'display': 'none',
				'autoAlpha': 0,
				'y': 100,
			}, {
				'display': 'block',
				'autoAlpha': 1,
				'y': 0,
				'duration': 1,
			});
		}
	});


	$('.j-cost-checkbox').on('change', function () {
		let $this = $(this);

		$('.j-cost-item').hide();

		if ($this.is(':checked')) {
			$('.j-cost-item.age-children').stop().fadeIn();
		} else {
			$('.j-cost-item.age-adults').stop().fadeIn();
		}
	});


}