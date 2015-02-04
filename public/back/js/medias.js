$(document).ready(function() {

	$("input").on('change', (function(e) {
		var files = e.target.files;
		var media_id = $('input[name="ID"]').val();
		var image_file = files[0];

		upload_image(media_id, image_file);
	}));

	$('.btn-activate-crop').click(function() {

		var modal = $('#crop-medias-modal');
		$(modal).modal('show');

		var media_format = $(this).closest('.media-format');
		var width = media_format.attr('data-width');
		var height = media_format.attr('data-height');
		var $image = $('.media-image-to-crop');

		$('.btn-valid-crop').attr('data-media-format-id', media_format.attr('data-media-format-id'));

		$image.cropper({
			aspectRatio: width / height,
			data: {
			    width: width,
			    height: height
			},
			done: function(data) {
			    $('#dataHeight').val(Math.round(data.height));
			    $('#dataWidth').val(Math.round(data.width));
			}
		});
	});

	$('.btn-valid-crop').click(function() {

		var media_format_id = $(this).attr('data-media-format-id');
		var media_format = $('.media-format[data-media-format-id="' + media_format_id + '"]');
		//$(media_format).find('.btn-activate-crop').show();
		var modal = $('#crop-medias-modal');
		$(modal).modal('hide');

		var media_id = $('input[name="ID"]').val();

		var $image = $('.media-image-to-crop');

		var data = $image.cropper("getData", true);

		$image.cropper("destroy");

		data.ID = media_id;
		data.media_format_id = media_format_id;

		$.ajax({
	    	url: route_media_crop,
			type: "POST",
			data: data,
	    	cache: false,
			success: function(data)
		    {
				$(media_format).find('.media-format-image img').remove();
				$(media_format).find('.media-format-image').append($('<img>',{src:data.image + '?' + new Date().getTime()}));
		    }	        
	   });

	});	
});

function upload_image(media_id, image_url) {
	var data = new FormData();
	data.append('ID', media_id);
    data.append('image', image_url);

	$.ajax({
    	url: route_media_upload,
		type: "POST",
		data:  data,
		contentType: false,
	    cache: false,
		processData:false,
		success: function(data)
	    {
			$('.media-thumbnail img').remove();
			$('.media-thumbnail').append($('<img>',{src:data.image + '?' + new Date().getTime()}));
			$('#file_name').val(data.file_name);
			for(var i in data.media_format_images) {
				var media_format = data.media_format_images[i];
				var media_format_div = $('.media-format[data-media-format-id="' + media_format.media_format_id + '"]');

				$(media_format_div).find('.media-format-image img').remove();
				$(media_format_div).find('.media-format-image').append($('<img>',{src:media_format.image + '?' + new Date().getTime()}));
			}
	    }	        
   });
}