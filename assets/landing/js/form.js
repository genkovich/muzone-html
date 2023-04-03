export function formInit($, Fancybox) {

	const $document = $(document);
	let $form = $('.j-form');

	let validator = $form.jbvalidator({
		errorMessage: true,
		successClass: true,
		html5BrowserDefault: false,
		validClass: 'valid',
		invalidClass: 'invalid',
		language: 'build/libs/form/ua.json',
	});

	$document.on('submit', '.j-form', function (event) {
		let $this = $(this),
			data = new FormData($this[0]);

		$this.prepend('<div class="loader"><img src="' + target + '/img/loader.svg" alt="" role="presentation"></div>');

		let $loader = $this.find('.loader');

		$this.find('[required]').val('');

		Fancybox.close();
		Fancybox.show(
			[{
				src: '#ok',
			}], opts_fancybox
		);

		gsap.to($loader[0], {
			display: 'none',
			opacity: 0,
			duration: .3,
			onComplete: function () {
				$loader.remove();
			},
		});

		return false;
	});


	$('.j-phone-item').on('click', function () {
		let $this = $(this),
			index = $this.closest('li').index(),
			$wrapper = $this.closest('.j-phone'),
			$bl = $wrapper.find('.j-phone-bl'),
			$input = $bl.find('input');

		if (!$this.is('.active')) {
			$wrapper.find('.j-phone-item').removeClass('active');
			$this.addClass('active');

			$bl.removeClass('active')
			$input.removeAttr('required');

			$bl.eq(index).addClass('active')
			$input.eq(index)
				.focus()
				.attr('required', '');

			$wrapper.find('[data-target]').trigger('click');
		}
	});

	$('.j-phone-mask').inputmask('+38(099)-999-99-99', {
		validationEventTimeOut: 0,
	});
}