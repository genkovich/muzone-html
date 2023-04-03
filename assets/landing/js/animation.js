export function animationInit(gsap, ScrollToPlugin, ScrollTrigger, Quad, $) {

	const $window = $(window);
// register gsap plugin-----------------------------
	gsap.registerPlugin(ScrollToPlugin, ScrollTrigger);


	// scroll trigger update----------------------------
	$window.on('resize', function () {
		ScrollTrigger.refresh();
	});
	$window.on('scroll', function () {
		ScrollTrigger.refresh();
	});


	// animate wow--------------------------------------------
	$('.j-wow').each(function (e, el) {
		ScrollTrigger.create({
			trigger: el,
			once: true,
			onEnter: function () {
				animateFrom(el)
			},
		});
	});

	function animateFrom(el) {
		let $el = $(el),
			delay = $el.attr('data-delay'),
			ease = Quad.easeInOut,
			duration = '1';

		if ($el.is('.j-wow-right')) {
			gsap.from(el, {
				x: 100,
				autoAlpha: 0,
				duration: duration,
				delay: delay,
				ease: ease,
			});
		}
		if ($el.is('.j-wow-left')) {
			gsap.from(el, {
				x: -100,
				autoAlpha: 0,
				duration: duration,
				delay: delay,
				ease: ease,
			});
		}
		if ($el.is('.j-wow-bottom')) {
			gsap.from(el, {
				y: 100,
				autoAlpha: 0,
				duration: duration,
				delay: delay,
				ease: ease,
			});
		}
		if ($el.is('.j-wow-top')) {
			gsap.from(el, {
				y: -100,
				autoAlpha: 0,
				duration: duration,
				delay: delay,
				ease: ease,
			});
		}
		if ($el.is('.j-wow-class')) {
			setTimeout(() => {
				$(el).addClass('animated');
			}, delay * 1000);
		}
		if (el.classList.contains('j-wow-numbers')) {
			$el.prop('Counter', 0).animate({
				Counter: Number($el.text()),
			}, {
				duration: 4000,
				easing: 'swing',
				step: function (now) {
					$el.text(Math.ceil(now));
				}
			});
		}
	}


	// mouse parallax-----------------------------------------
	$('.j-mouse-parallax').each(function () {
		let $this = $(this),
			$wrapper = $this.closest('.j-mouse-parallax-wrapper');

		$wrapper.on('mousemove', function (e) {
			parallaxIt(e, $this[0], this, 50);
		});
	});

	function parallaxIt(e, target, container, movement) {
		let $this = $(container),
			relX = e.pageX - $this.offset().left,
			relY = e.pageY - $this.offset().top;


		gsap.to(target, 1, {
			x: (relX - $this.width() / 2) / $this.width() * movement,
			y: (relY - $this.height() / 2) / $this.height() * movement,
		});
	}


	// parallax bg ------------------------------------------
	$('.j-parallax-bg').each(function () {
		let $this = $(this);

		if ($this.is(':visible')) {
			gsap.to(this, {
				y: '50%',
				scrollTrigger: {
					trigger: $this.closest('.j-parallax-bg-sec')[0],
					start: '0',
					end: '100%',
					scrub: true,
				}
			});
		}
	});
}