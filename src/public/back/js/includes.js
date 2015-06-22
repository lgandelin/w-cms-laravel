$(document).ready(function() {

    //Medias modal
    $('body').on('click', '.open-medias-modal', function() {
        var modal = $('#medias-modal');
        modal.attr('data-div-id', $(this).attr('data-div-id'));
        $(modal).modal('show');
    });

    $('body').on('click', '.popup-media-id', function(e) {
        e.preventDefault();

        var media_id = $(this).attr('data-id');
        var media_name = $(this).attr('data-name');
        var media_src = $(this).attr('data-src');
        var div_id = $('#medias-modal').attr('data-div-id');

        var div = $('#' + div_id);
        div.find('input[name="mediaID"]').val(media_id);
        div.find('.media-name').text(media_name);
        div.find('.thumbnail img').attr('src', media_src);
        $('#medias-modal').modal('hide');
    });

    //Delete media
    $('body').on('click', '.delete-media', function() {

        var div = $('#' + $(this).attr('data-div-id'));
        div.find('img').removeAttr('src');
        div.find('.media-name').text('Pas de média associé');
        div.find('input[name="mediaID"]').val('');
    });

    //New media from popup
    $('body').on('click', '.new-media', function() {
        var modal = $('#medias-modal');
        $(modal).modal('hide');
    });

    $('#new-media-modal input[type="file"]').on('change', (function(e) {
        var files = e.target.files;
        var image_file = files[0];
        var media_name = $('#new-media-modal input[name="name"]').val();
        var media_alt = $('#new-media-modal input[name="alt"]').val();
        var media_title = $('#new-media-modal input[name="title"]').val();
        create_and_upload_image(image_file, media_name, media_alt, media_title);
    }));

    $('#new-media-modal input[type="submit"]').on('click', function() {
        var modal = $('#new-media-modal');
        $(modal).modal('hide');

        var modal = $('#medias-modal');

        var media_id = $('#new-media-modal .new-media-id').val();
        var media_name = $('#new-media-modal input[name="name"]').val();
        var media_alt = $('#new-media-modal input[name="alt"]').val();
        var media_src = $('#new-media-modal .media-thumbnail img').attr('src');
        $('#medias-modal li:last-child').before('<li style="display: inline-block; padding-right: 20px; vertical-align: middle; text-align: center"><a href="#" class="thumbnail popup-media-id" data-id="' + media_id + '" data-name="' + media_name + '" data-src="' + media_src + '"><img src="' + media_src+ '" alt="' + media_alt + '" width="175"><span class="media-name" style="font-weight: bold;">' + media_name + '</span></a></li>');
        $(modal).modal('show');

        //Reset fields
        $('#new-media-modal input[name="name"]').val('');
        $('#new-media-modal .media-thumbnail').hide();
        $('#new-media-modal input[name="title"]').val('');
        $('#new-media-modal input[name="alt"]').val('');
    });
});

function upload_image(media_id, image_url) {
    var data = new FormData();
    data.append('ID', media_id);
    data.append('image', image_url);
    data.append('_token', $('input[name="_token"]').val());

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
        }
    });
}

function create_and_upload_image(image_url, media_name, media_alt, media_title) {
    var data = new FormData();
    data.append('name', media_name);
    data.append('alt', media_alt);
    data.append('title', media_title);
    data.append('image', image_url);
    data.append('_token', $('input[name="_token"]').val());

    $.ajax({
        url: route_media_create_and_upload,
        type: "POST",
        data:  data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
        {
            $('.media-thumbnail img').remove();
            $('.media-thumbnail').show().append($('<img>',{src:data.image + '?' + new Date().getTime()}).css('max-width', '100%'));
            $('#file_name').val(data.file_name);
            $('.new-media-id').val(data.media_id);
        }
    });
}