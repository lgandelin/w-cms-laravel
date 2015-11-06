$(document).ready(function() {
    $('input[type="file"]').on('change', (function(e) {
        var files = e.target.files;
        var media_id = $('input[name="ID"]').val();
        var image_file = files[0];

        upload_image(media_id, image_file);
    }));

    $('.media-edit').on('click', '.btn-activate-crop', function() {

        var modal = $('#crop-medias-modal');
        $(modal).modal('show');

        var media_format = $(this).closest('.media-format');
        var width = media_format.attr('data-width');
        var height = media_format.attr('data-height');
        var preserve_ratio = media_format.attr('data-preserve-ratio');
        var $image = $('.media-image-to-crop');

        $('.btn-valid-crop').attr('data-media-format-id', media_format.attr('data-media-format-id'));

        $image.cropper({
            aspectRatio: (preserve_ratio > 0) ? (width / height) : false,
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

    $('.media-edit').on('click', '.btn-valid-crop', function() {
        var media_format_id = $(this).attr('data-media-format-id');
        var media_format = $('.media-format[data-media-format-id="' + media_format_id + '"]');

        var modal = $('#crop-medias-modal');
        $(modal).modal('hide');

        var media_id = $('input[name="ID"]').val();

        var $image = $('.media-image-to-crop');

        var data = $image.cropper("getData", true);

        $image.cropper("destroy");

        data.ID = media_id;
        data.media_format_id = media_format_id;
        data._token = $('input[name="_token"]').val();

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

$('.medias-list').on('click', '.media-folder .folder', function(e) {
    e.preventDefault();
    load_medias_library($(this).closest(".media-folder").data("media-folder-id"));
});

$('.medias-list .btn-back').click(function(e) {
    e.preventDefault();
    load_medias_library($('#parent-media-folder-id').val());
});

$('.btn-create-folder').click(function(e) {
    e.preventDefault();

    var data = {
        name: $("#new-folder-name").val(),
        parent_id: $("#current-media-folder-id").val(),
        _token: $('input[name="_token"]').val(),
    }

    $("#medias-library .update-in-progress").show();

    $.ajax({
        url: route_medias_folder_create,
        type: "POST",
        data: data,
        cache: false,
        success: function(data)
        {
            if (data.success) {
                $("#new-folder-name").val("");
                $("#medias-library .update-in-progress").hide();
                $('#medias-library .medias').append(get_template("media-folder-template", data.mediaFolder));
            }
        }
    });
});

$('.medias-list').on('click', '.media-folder .btn-delete-folder', function(e) {
    e.preventDefault();
    var ID = $(this).closest(".media-folder").attr("data-media-folder-id");

    var data = {
        ID: ID,
        _token: $('input[name="_token"]').val(),
    }

    $("#medias-library .update-in-progress").show();

    $.ajax({
        url: route_medias_folder_delete + "/" + ID,
        type: "POST",
        data: data,
        cache: false,
        success: function(data)
        {
            $("#medias-library .update-in-progress").hide();
            if (data.success) {
                $('.media-folder[data-media-folder-id="' + data.mediaFolderID + '"]').remove();
            }
        }
    });
});

function load_medias_library(mediaFolderID) {
    $("#medias-library .update-in-progress").show();

    $.ajax({
        url: route_get_medias,
        type: "GET",
        cache: false,
        dataType: 'JSON',
        data: {
            mediaFolderID: mediaFolderID
        },
        success: function(data)
        {
            if (data.mediaFolder && data.mediaFolder.parentID !== "") {
                $('#parent-media-folder-id').val(data.mediaFolder.parentID);
                $('#current-media-folder-id').val(data.mediaFolder.ID);
            }
            $("#medias-library .medias li").remove();
            $("#medias-library .update-in-progress").hide();

            for (var i in data.medias) {
                var media = data.medias[i];
                if (media.fileName) {
                    $('#medias-library .medias').append(get_template("media-template", media));
                } else {
                    $('#medias-library .medias').append(get_template("media-folder-template", media));
                }
            }
        }
    });
}

function get_template(template, variables) {
    var source = $("#" + template).html();
    var template = Handlebars.compile(source);

    return template(variables)
}