export function formInit($) {

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