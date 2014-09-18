$(document).ready(function() {

	/********************************
	* CONTENT
	********************************/

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
                	var label_success = $('<p class="alert alert-success">Saved !</p>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                	button.parent().after(label_error);
                	label_error.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
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
                	var label_success = $('<p class="alert alert-success">Saved !</p>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                	button.parent().after(label_error);
                	label_error.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                }
            }
        });

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
                	var label_success = $('<p class="alert alert-success">Saved !</p>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                	button.parent().after(label_error);
                	label_error.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');
                }
            }
        });

	});

	$('.area > .title, .block > .title').click(function() {
		$(this).next().toggle();
	});

	$('.page-content-close-block').click(function() {
		$(this).closest('.content').hide();
	});



	/********************************
	* STRUCTURE
	********************************/

	//Update block
	$('.block-update').click(function() {
		$('.update-area-form, .update-block-form').hide();

		var block_id = $(this).attr('data-id');
		$('.page-content-update-block').attr('data-id', block_id);

		var block = $('.block[data-id="' + block_id + '"]');

		var url = '/admin/editorial/pages/get_block_infos/' + block_id;

		$.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
					$('.update-block-form .name').val(data.block.name);
					$('.update-block-form .width').val(data.block.width);
					$('.update-block-form .height').val(data.block.height);
					$('.update-block-form .class').val(data.block.class);
					$('.update-block-form .type').val(data.block.type);

					$('.update-block-form').show();
                } else {
                    
                }
            }
        });
	});

	//Valid update block
	$('.page-content-update-block').click(function() {
		var block_id = $(this).attr('data-id');
		var block = $('#structure .block[data-id="' + block_id + '"]');

		var url = '/admin/editorial/pages/update_block_infos';
		var input_data = {
			'ID': block_id,
            'name': $('.update-block-form .name').val(),
            'width': $('.update-block-form .width').val(),
            'type': $('.update-block-form .type').val(),
            'class': $('.update-block-form .class').val()
        };

	    var button = $(this);
	    button.val('Saving ...');

		$.ajax({
            type: "POST",
            url: url,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
					var label_success = $('<p class="alert alert-success">Saved !</p>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');

                	//Update block in "Structure" tab
                	block.removeClass().addClass('block col-xs-' + input_data.width);
                	block.find('.width_value').text(input_data.width);
                	block.find('.name').text(input_data.name);
                	block.find('.type').text('(' + input_data.type.toUpperCase() + ')');

                	//Update block in "Content" tab
                	$('#content .block[data-id="' + block_id + '"]').find('.block_name').text(input_data.name);
                } else {
                    
                }
            }
        });
	});

	$('.update-block-form .page-content-close-update-block').click(function() {
		$('.update-block-form').hide();
	});



	//Update area
	$('.area-update').click(function() {
		$('.update-area-form, .update-block-form').hide();
		
		var area_id = $(this).attr('data-id');
		$('.page-content-update-area').attr('data-id', area_id);

		var area = $('.area[data-id="' + area_id + '"]');

		var url = '/admin/editorial/pages/get_area_infos/' + area_id;

		$.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
					$('.update-area-form .name').val(data.area.name);
					$('.update-area-form .width').val(data.area.width);
					$('.update-area-form .height').val(data.area.height);
					$('.update-area-form .class').val(data.area.class);

					$('.update-area-form').show();
                } else {
                    
                }
            }
        });
	});

	//Valid update area
	$('.page-content-update-area').click(function() {
		var area_id = $(this).attr('data-id');
		var area = $('#structure .area[data-id="' + area_id + '"]');

		var url = '/admin/editorial/pages/update_area_infos';
		var input_data = {
			'ID': area_id,
            'name': $('.update-area-form .name').val(),
            'width': $('.update-area-form .width').val(),
            'class': $('.update-area-form .class').val()
        };

	    var button = $(this);
	    button.val('Saving ...');

		$.ajax({
            type: "POST",
            url: url,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
					var label_success = $('<p class="alert alert-success">Saved !</p>');
                	button.parent().after(label_success);
                	label_success.fadeIn().delay(2000).fadeOut();
                	button.val('Submit');

                	//Update area in "Structure" tab
                	area.removeClass().addClass('area col-xs-' + input_data.width);
                	area.find('.area_width .width_value').text(input_data.width);
                	area.find('.area_name').text(input_data.name);

                	//Update area in "Content" tab
                	$('#content .area[data-id="' + area_id + '"]').find('.area_name').text(input_data.name);
                } else {
                    
                }
            }
        });
	});

	$('.update-area-form .page-content-close-update-area').click(function() {
		$('.update-area-form').hide();
	});

	//Delete area
	$('.area-delete').click(function() {
		if (confirm('Are you sure that you want to delete this area ?')) {
			var area_id = $(this).attr('data-id');
			
			var url = '/admin/editorial/pages/delete_area';
	        var data = {
	            'ID': area_id
	        };

	        $.ajax({
	            type: "POST",
	            url: url,
	            data: data,
	            success: function(data) {
	                data = JSON.parse(data);

	                if (data.success) {
	                	$('.area[data-id="' + area_id + '"]').remove();
	                	var label_success = $('<p class="alert alert-success">Saved !</p>');
	                	$('#structure .row').after(label_success);
	                	label_success.fadeIn().delay(2000).fadeOut();
	                } else {
	                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
	                	$('#structure .row').after(label_error);
	                	label_error.fadeIn().delay(2000).fadeOut();
	                }
	            }
	        });
		}
	});

	//Delete block
	$('.block-delete').click(function() {
		if (confirm('Are you sure that you want to delete this block ?')) {
			var block_id = $(this).attr('data-id');
			
			var url = '/admin/editorial/pages/delete_block';
	        var data = {
	            'ID': block_id
	        };

	        $.ajax({
	            type: "POST",
	            url: url,
	            data: data,
	            success: function(data) {
	                data = JSON.parse(data);

	                if (data.success) {
	                	$('.block[data-id="' + block_id + '"]').remove();
	                	var label_success = $('<p class="alert alert-success">Saved !</p>');
	                	$('#structure .row').after(label_success);
	                	label_success.fadeIn().delay(2000).fadeOut();
	                } else {
	                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
	                	$('#structure .row').after(label_error);
	                	label_error.fadeIn().delay(2000).fadeOut();
	                }
	            }
	        });
		}
	});

});