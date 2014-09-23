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
	$('body').on('click', '.page-content-save-block', function() {
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

	$('body').on('click', '.area > .title, .block > .title', function() {
		$(this).next().toggle();
	});

	$('body').on('click', '.page-content-close-block', function() {
		$(this).closest('.content').hide();
	});







	/********************************
	* STRUCTURE
	********************************/

	//Create area
	$('body').on('click', '.page-content-create-area', function() {
		$('.create-area-form, .create-block-form').hide();
		$('.update-area-form, .update-block-form').hide();

		$('.create-area-form').show();
	});

	$('body').on('click', '.page-content-valid-create-area', function() {
		var url = '/admin/editorial/pages/create_area';
		var input_data = {
            'name': $('.create-area-form .name').val(),
            'width': $('.create-area-form .width').val(),
            'height': $('.create-area-form .height').val(),
            'class': $('.create-area-form .class').val(),
            'page_id': $('.create-area-form .page_id').val()
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

                	//Create area in "Structure" tab
                	var area_content = '<div data-id="' + data.area.ID + '" class="area col-xs-' + data.area.width + '"><div class="area_color"><span class="title"><span class="area_name">' + data.area.name + '</span> <span class="area_width">[<span class="width_value">' + data.area.width + '</span>]</span><span data-id="' + data.area.ID + '" class="area-delete glyphicon glyphicon-remove"></span><span data-id="' + data.area.ID + '" class="area-update glyphicon glyphicon-pencil"></span><span data-id="' + data.area.ID + '" class="area-create-block glyphicon glyphicon-plus"></span></span></div></div>';
                    $('#structure > .row').append(area_content);

                	//Create area in "Content" tab
                	var area_content = '<div class="area" data-id="' + data.area.ID + '"><span class="title"><span class="area_name">' + data.area.name + '</span></span><div class="content"></div></div>';
                	$('#content .form-group:last-child').append(area_content);
                } else {
                    
                }
            }
    	});
    });




	//Create block
	$('body').on('click', '.area-create-block', function() {
		$('.create-area-form, .create-block-form').hide();
		$('.update-area-form, .update-block-form').hide();

		$('.create-block-form .area_id').val($(this).attr('data-id'));
		$('.create-block-form').show();
	});

	$('body').on('click', '.page-content-valid-create-block', function() {
		var url = '/admin/editorial/pages/create_block';
		var input_data = {
            'name': $('.create-block-form .name').val(),
            'width': $('.create-block-form .width').val(),
            'height': $('.create-block-form .height').val(),
            'type': $('.create-block-form .type').val(),
            'class': $('.create-block-form .class').val(),
            'area_id': $('.create-block-form .area_id').val()
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

                	//Create block in "Structure" tab
                	var block_content = '<div data-id="' + data.block.ID + '" class="block col-xs-' + data.block.width + '"><div class="block_color"><span class="title"><span class="name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span> [<span class="width_value">' + data.block.width + '</span>]<span data-id="' + data.block.ID + '" class="block-delete glyphicon glyphicon-remove"></span><span data-id="' + data.block.ID + '" class="block-update glyphicon glyphicon-pencil"></span></span></div></div>';
                    $('#structure .area[data-id="' + input_data.area_id + '"] .area_color').append(block_content);

                	//Create block in "Content" tab
                	var block_content = '<div class="block" data-id="' + data.block.ID + '"><span class="title"><span class="block_name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span></span><div class="content"><textarea class="ckeditor" id="editor' + data.block.ID + '" name="editor' + data.block.ID + '"></textarea><!-- Save --><div class="submit_wrapper"><input data-id="' + data.block.ID + '" class="page-content-save-block btn btn-success" value="Submit" type="button"><input data-id="' + data.block.ID + '" class="page-content-close-block btn btn-default" value="Close" type="button"></div><!-- Save --></div></div>';
                	$('#content .area[data-id="' + input_data.area_id + '"] > .content').append(block_content);
                	CKEDITOR.replace( 'editor' + data.block.ID);
                } else {
                    
                }
            }
        });

	});

	//Update block
	$('body').on('click', '.block-update', function() {
		$('.create-area-form, .create-block-form').hide();
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
	$('body').on('click', '.page-content-update-block', function() {
		var block_id = $(this).attr('data-id');
		var block = $('#structure .block[data-id="' + block_id + '"]');

		var url = '/admin/editorial/pages/update_block_infos';
		var input_data = {
			'ID': block_id,
            'name': $('.update-block-form .name').val(),
            'width': $('.update-block-form .width').val(),
            'height': $('.update-block-form .height').val(),
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

	$('.update-block-form .page-content-close-update-block').on( "click", function() {
		$('.update-block-form').hide();
	});

	$('.create-block-form .page-content-close-create-block').on( "click", function() {
		$('.create-block-form').hide();
	});

	$('.create-area-form .page-content-close-create-area').on( "click", function() {
		$('.create-area-form').hide();
	});

	//Update area
	$('body').on('click', '.area-update', function() {
		$('.create-area-form, .create-block-form').hide();
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
	$('body').on('click', '.page-content-update-area', function() {
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

	$('.update-area-form .page-content-close-update-area').on( "click", function() {
		$('.update-area-form').hide();
	});

	//Delete area
	$('body').on('click', '.area-delete', function() {
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
	$('body').on('click', '.block-delete', function() {
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