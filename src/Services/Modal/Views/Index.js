import "./Index.scss";

jQuery(document).ready(function ($) {

	$('.inpsyde-open-modal').on('click', function (event) {
		var idModal = $(this).data('modal');
		$('#' + idModal).removeClass('hidden');
	});

	$('.inpsyde-modal__close').on('click', function (event) {
		$(this).closest('.inpsyde-modal').addClass('hidden');
	});

	$('.inpsyde-modal__overflow').on('click', function (event) {
		if ($('.inpsyde-modal__close').length) {
			$(this).closest('.inpsyde-modal').addClass('hidden');
		}
	});

});