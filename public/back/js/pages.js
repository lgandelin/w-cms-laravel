$(document).ready(function() {

	//Save page infos
	$('.page-content-save-infos').click(function() {
		var page_id = $(this).attr('data-id');
		var name = $('#name').val();
		var identifier = $('#identifier').val();

		var url = '/admin/editorial/pages/update_page_infos';
        var data = {
            'ID': page_id,
            'name': name,
            'identifier': identifier
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                	var label_success = $('<p class="alert alert-success">Saved !</sp>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    alert(data.error);
                }
            }
        });

	});

	//Save page seo
	$('.page-content-save-seo').click(function() {
		var page_id = $(this).attr('data-id');
		var uri = $('#uri').val();
		var meta_title = $('#meta_title').val();
		var meta_description = $('#meta_description').val();
		var meta_keywords = $('#meta_keywords').val();

		var url = '/admin/editorial/pages/update_page_seo';
        var data = {
            'ID': page_id,
            'uri': uri,
            'meta_title': meta_title,
            'meta_description': meta_description,
            'meta_keywords': meta_keywords
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                	var label_success = $('<p class="alert alert-success">Saved !</sp>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    alert(data.error);
                }
            }
        });

	});



	//BLOCS
	$('.area > .title, .block > .title').click(function() {
		$(this).next().toggle();
	});

	$('.page-content-close-block').click(function() {
		$(this).closest('.content').hide();
	});

	//Save content block
	$('.page-content-save-block').click(function() {
		var block_id = $(this).attr('data-id');
		var textarea_id = $('.block[data-id="' + block_id + '"] textarea').attr('id');
		var html = CKEDITOR.instances[textarea_id].getData();
		
		var url = '/admin/editorial/pages/update_block_content';
        var data = {
            'ID': block_id,
            'html': html
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                	var label_success = $('<p class="alert alert-success">Saved !</sp>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    alert(data.error);
                }
            }
        });

	});


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