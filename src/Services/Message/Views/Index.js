import "./Index.scss";

jQuery(document).ready(function ($) {

	$('.plugin-core-message__close').on('click', function (event) {
		$(this).closest('.plugin-core-message').addClass('hidden');
	});

});