$(document).ready(function() {

	$("input").on('change', (function(e) {
		var files = e.target.files;
		
		var data = new FormData();
		data.append('ID', 7);
	    $.each(files, function(key, value)
	    {
	        data.append('image', value);
	    });

		e.preventDefault();
		$.ajax({
        	url: route_media_upload,
			type: "POST",
			data:  data,
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
				$('.media-thumbnail img').attr('src', data.image);
		    }	        
	   });
	}));
});