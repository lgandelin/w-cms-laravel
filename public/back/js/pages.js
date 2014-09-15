$(document).ready(function() {

 	CKEDITOR.replace( 'text' );
 	
	$('.btn-delete-area').click(function() {
		$(this).parent().remove();
	});

	$('form').on('click', '.btn-create-area', function() {
		
		var name = $(this).parent().find('input[name="new_area_name"]').val();
		var width = $(this).parent().find('input[name="new_area_width"]').val();
		var height = $(this).parent().find('input[name="new_area_height"]').val();
		var order = $(this).parent().find('input[name="new_area_order"]').val();
		var css_class = $(this).parent().find('input[name="new_area_class"]').val();

		$(this).parent().find('input[name="new_area_name"]').val('');
		$(this).parent().find('input[name="new_area_width"]').val('');
		$(this).parent().find('input[name="new_area_height"]').val('');
		$(this).parent().find('input[name="new_area_order"]').val('');
		$(this).parent().find('input[name="new_area_class"]').val('');

		var wrapper = $('.new-area-pattern').clone();
		wrapper.removeClass('new-area-pattern').show();
		wrapper.find('input[name="areas_name[]"]').val(name);
		wrapper.find('h4').text(name);
		wrapper.find('input[name="areas_width[]"]').val(width);
		wrapper.find('input[name="areas_height[]"]').val(height);
		wrapper.find('input[name="areas_order[]"]').val(order);
		wrapper.find('input[name="areas_class[]"]').val(css_class);

		$('.new-area-pattern').before(wrapper);
	});



	

	$('.btn-delete-block').click(function() {
		$(this).parent().remove();
	});

	$('form').on('click', '.btn-create-block', function() {
		
		var name = $(this).parent().find('input[name="new_block_name"]').val();
		var width = $(this).parent().find('input[name="new_block_width"]').val();
		var height = $(this).parent().find('input[name="new_block_height"]').val();
		var order = $(this).parent().find('input[name="new_block_order"]').val();
		var css_class = $(this).parent().find('input[name="new_block_class"]').val();

		$(this).parent().find('input[name="new_block_name"]').val('');
		$(this).parent().find('input[name="new_block_width"]').val('');
		$(this).parent().find('input[name="new_block_height"]').val('');
		$(this).parent().find('input[name="new_block_order"]').val('');
		$(this).parent().find('input[name="new_block_class"]').val('');

		var wrapper = $('.new-block-pattern').clone();
		wrapper.removeClass('new-block-pattern').show();
		wrapper.find('input[name="blocks_name[]"]').val(name);
		wrapper.find('h4').text(name);
		wrapper.find('input[name="blocks_width[]"]').val(width);
		wrapper.find('input[name="blocks_height[]"]').val(height);
		wrapper.find('input[name="blocks_order[]"]').val(order);
		wrapper.find('input[name="blocks_class[]"]').val(css_class);

		$('.new-block-pattern').before(wrapper);
	});

});