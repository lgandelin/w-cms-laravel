$(document).ready(function() {

	var $image = $(".media-thumbnail img");

	$("input").on('change', (function(e) {
		var files = e.target.files;
		var image_id = $('input[name="ID"]').val();
		var image_file = files[0];

		upload_image(image_id, image_file);
	}));

	$('#btn-activate-crop').click(function() {
			$image.cropper({
			done: function(data) {
			    $('#dataHeight').val(Math.round(data.height));
			    $('#dataWidth').val(Math.round(data.width));
			}
		});
	});

	$('#btn-valid-crop').click(function() {
		var url = $image.cropper("getDataURL", "image/jpeg", 0.65);
		var image_id = $('input[name="ID"]').val();
		var image_file = dataURItoBlob(url);
		
		$image.cropper("destroy");
		upload_image(image_id, image_file);
	});	
});

function upload_image(image_id, image_url) {
	var data = new FormData();
	data.append('ID', image_id);
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
	    }	        
   });
}

function dataURItoBlob(dataURI) {
    // convert base64 to raw binary data held in a string
    // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    var byteString = atob(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to an ArrayBuffer
    var ab = new ArrayBuffer(byteString.length);
    var dw = new DataView(ab);
    for(var i = 0; i < byteString.length; i++) {
        dw.setUint8(i, byteString.charCodeAt(i));
    }

    // write the ArrayBuffer to a blob, and you're done
    return new Blob([ab], {type: mimeString});
}