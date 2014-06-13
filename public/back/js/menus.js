$(document).ready(function() {

	$('form').on('click', '.btn-delete', function() {
		$(this).parent().remove();
	});

	$('form').on('click', '.btn-create', function() {
		var label = $(this).parent().find('input[name="items_label[]"]').val();
		var order = $(this).parent().find('input[name="items_order[]"]').val();
		var page = $(this).parent().find('select').val();

		$(this).parent().find('input[name="items_label[]"]').val('');
		$(this).parent().find('input[name="items_order[]"]').val('');
		$(this).parent().find('select').val('');

		var wrapper = $('.new-menu-pattern').clone();
		wrapper.removeClass('new-menu-pattern').show();
		wrapper.find('input[name="items_label[]"]').val(label);
		wrapper.find('input[name="items_order[]"]').val(order);
		wrapper.find('select').val(page);

		$('.new-menu-pattern').before(wrapper);
	});
});