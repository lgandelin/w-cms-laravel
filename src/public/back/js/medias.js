$(document).ready(function() {

    /*$('input[type="file"]').on('change', (function(e) {
        var files = e.target.files;
        var media_id = $('input[name="ID"]').val();
        var image_file = files[0];

        upload_image(media_id, image_file);
    }));*/

    $('.panel-create-media').on('change', function(e) {
        e.preventDefault();
        $("#temp-medias-library").show();
        $("#temp-medias-library .update-in-progress").show();

        var files = e.target.files;
        for (var i = 0; i < files.length; i++) {
            var image_file = files[i];
            var data = new FormData();
            data.append('image', image_file);
            data.append('_token', $('input[name="_token"]').val());
            var lastFile = (i == files.length - 1);

            $.ajax({
                url: route_media_upload,
                type: "POST",
                data:  data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    $('#temp-medias-library .medias').append(get_template("temp-media-template", data));
                    //$('.new-media-preview').empty();
                    //$('.new-media-preview').append($('<img/>').attr('src', data.fileName).css('max-width', '100%').css('margin-bottom', '10px').addClass('thumbnail'));
                    //$('#new-media-name').val(data.baseFileName);

                    if (lastFile) {
                        $("#temp-medias-library .update-in-progress").hide();
                    }
                }
            });
        }
    });

    $('#temp-medias-library').on('click', '.btn-create-media', function(e) {
        e.preventDefault();
        $("#medias-library .update-in-progress").show();
        var tempMedia = $(this).closest('.temp-media');

        var data = {
            fileName: tempMedia.find('.thumbnail img').attr('src'),
            name: tempMedia.find('.new-media-name').val(),
            title: tempMedia.find('.new-media-title').val(),
            alt: tempMedia.find('.new-media-alt').val(),
            _token: $('input[name="_token"]').val(),
            mediaFolderID: $('#current-media-folder-id').val(),
        }

        $.ajax({
            url: route_media_store,
            type: "POST",
            data:  data,
            cache: false,
            success: function(data)
            {
                $("#medias-library .update-in-progress").hide();
                $('#medias-library .medias').append(get_template("media-template", data.media));
                tempMedia.fadeOut().remove();
                init_media_draggable();
                init_media_folder_draggable();
                init_media_folder_droppable();

                if ($('#temp-medias-library .medias').children().length == 0) {
                    $('#temp-medias-library').fadeOut();
                }
            }
        });
    });

    $('#temp-medias-library').on('click', '.btn-cancel-media', function(e) {
        e.preventDefault();
        var tempMedia = $(this).closest('.temp-media');
        tempMedia.fadeOut().remove();

        if ($('#temp-medias-library .medias').children().length == 0) {
            $('#temp-medias-library').fadeOut();
        }
    });

    $('.btn-create-all-medias').on('click', function(e) {
        e.preventDefault();

        $('#temp-medias-library .temp-media').each(function() {
            $(this).find('.btn-create-media').trigger('click')
        });
    });

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
                $('#medias-library .media-folders').append(get_template("media-folder-template", data.mediaFolder));

                init_media_draggable();
                init_media_folder_draggable();
                init_media_folder_droppable();
            }
        }
    });
});

$('.medias-list').on('click', '.media-folder .btn-delete-folder', function(e) {
    e.preventDefault();
    var ID = $(this).closest(".media-folder").attr("data-media-folder-id");

    var data = {
        ID: ID,
        _token: $('input[name="_token"]').val()
    }

    $("#medias-library .update-in-progress").show();

    $.ajax({
        url: route_medias_folder_delete,
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

$('.medias').on('click', '.media .media-delete', function(e) {
    e.preventDefault();
    var ID = $(this).closest(".media").attr("data-media-id");

    var data = {
        ID: ID,
        _token: $('input[name="_token"]').val()
    }

    $("#medias-library .update-in-progress").show();

    $.ajax({
        url: route_medias_delete,
        type: "POST",
        data: data,
        cache: false,
        success: function(data)
        {
            $("#medias-library .update-in-progress").hide();
            if (data.success) {
                $('.media[data-media-id="' + data.mediaID + '"]').remove();
            }
        }
    });
});

$('.medias-list .breadcrumb').on('click', 'li', function(e) {
    e.preventDefault();
    load_medias_library($(this).attr('data-media-folder-id'));
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
                $('.btn-back').show();
            } else {
                $('.btn-back').hide();
            }

            $("#medias-library .medias li").remove();
            $("#medias-library .media-folders li").remove();
            $("#medias-library .update-in-progress").hide();

            for (var i in data.medias) {
                var media = data.medias[i];
                if (media.fileName) {
                    $('#medias-library .medias').append(get_template("media-template", media));
                } else {
                    $('#medias-library .media-folders').append(get_template("media-folder-template", media));
                }
            }

            //Update breadcrumb
            $('.medias-list .breadcrumb').empty();
            for (var i in data.breadcrumb) {
                $('.medias-list .breadcrumb').append($('<li data-media-folder-id="' + data.breadcrumb[i].ID + '"><a href="">' + data.breadcrumb[i].name + '</a></li>'));
            }
            if (data.mediaFolder && data.mediaFolder.name) {
                $('.medias-list .breadcrumb').append($('<li data-media-folder-id="' + data.mediaFolder.ID + '">' + data.mediaFolder.name + '</li>').addClass('active'));
            }

            init_media_draggable();
            init_media_folder_draggable();
            init_media_folder_droppable();
        }
    });
}

function init_media_draggable()
{
    $('.medias .media').draggable({
        cursor: "move",
        placeholder: 'sortable-placeholder',
        zIndex: 25,
        revert: true,
        refreshPositions: true
    });
}

function init_media_folder_draggable()
{
    $('.media-folders .media-folder').draggable({
        cursor: "move",
        placeholder: 'sortable-placeholder',
        zIndex: 25,
        revert: true,
        refreshPositions: true
    });
}

function init_media_folder_droppable()
{
    var dropOptions = {
        hoverClass: 'ui-state-draggable-hover',
        accept: '.media, .media-folder',
        drop: function(event, ui) {
            if (ui.draggable.hasClass('media')) {
                var mediaID = ui.draggable.data('media-id');
                var mediaFolderID = $(this).data('media-folder-id');

                var data = {
                    mediaID: mediaID,
                    mediaFolderID: mediaFolderID,
                    _token: $('input[name="_token"]').val()
                }
                $('.media[data-media-id="' + mediaID + '"]').fadeOut();

                $.ajax({
                    url: route_media_move_in_media_folder,
                    type: "POST",
                    cache: false,
                    dataType: 'JSON',
                    data: data,
                    success: function(data)
                    {

                    }
                });
            } else if (ui.draggable.hasClass('media-folder')) {
                var mediaFolderID = ui.draggable.data('media-folder-id');
                var parentMediaFolderID = $(this).data('media-folder-id');

                var data = {
                    mediaFolderID: mediaFolderID,
                    parentMediaFolderID: parentMediaFolderID,
                    _token: $('input[name="_token"]').val()
                }
                $('.media-folder[data-media-folder-id="' + mediaFolderID + '"]').fadeOut();

                $.ajax({
                    url: route_media_folders_move_in_media_folder,
                    type: "POST",
                    cache: false,
                    dataType: 'JSON',
                    data: data,
                    success: function(data)
                    {

                    }
                });
            }

        }
    };

    $('.media-folder').droppable(dropOptions);
}