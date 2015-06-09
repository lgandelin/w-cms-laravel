$(document).ready(function() {

	//Save page infos
    $('.page-content-save-infos').click(function() {
        var page_id = $(this).attr('data-id');
        var name = $('#name').val();
        var identifier = $('#identifier').val();
        var is_master = $('input[name="is_master"]:checked').val();

        var data = {
            'ID': page_id,
            'name': name,
            'identifier': identifier,
            'is_master': is_master,
            '_token': $('input[name="_token"]').val()
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: route_pages_update_infos,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
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

        var data = {
            'ID': page_id,
            'uri': uri,
            'meta_title': meta_title,
            'meta_description': meta_description,
            'meta_keywords': meta_keywords,
            '_token': $('input[name="_token"]').val()
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: route_pages_update_seo,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
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
        var block = $('.block[data-id="' + block_id + '"]');

        var data = {
            'ID': block_id,
            'type' : block.data('type'),
            '_token': $('input[name="_token"]').val()
        };

        $('.block[data-id="' + block_id + '"] *[name]').each(function() {
            var value = $(this).val();
            if ($(this).attr('type') == 'radio') {
                value = $('.block[data-id="' + block_id + '"] input[name="' + $(this).attr('name') + '"]:checked').val()
            } else if ($(this).hasClass('ckeditor')) {
                value = CKEDITOR.instances[$(this).attr('id')].getData();
            }
            data[$(this).attr('name')] = value;
        });

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: route_blocks_update_content,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
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

     $('body').on('click', '.area:not(.child-area) > .title, .block:not(.child-block) > .title', function() {
        $(this).next().toggle();
        $(this).find('> .opening-status').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');
    });

    $('body').on('click', '.page-content-close-block', function() {
        $(this).closest('.content').hide();
        $(this).closest('.block').find('.opening-status').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');
    });

    //Medias modal
    $('body').on('click', '.open-medias-modal', function() {
        var modal = $('#medias-modal');
        var block_id = $(this).closest('.block').attr('data-id');
        modal.attr('data-block-id', block_id);
        modal.attr('data-name', $(this).attr('data-name'));
        modal.attr('data-src', $(this).attr('data-src'));
        $(modal).modal('show');
    });

    $('body').on('click', '.popup-media-id', function(e) {
        e.preventDefault();

        var media_id = $(this).attr('data-id');
        var media_name = $(this).attr('data-name');
        var media_src = $(this).attr('data-src');
        var block_id = $('#medias-modal').attr('data-block-id');

        var block = $('.block[data-id="' + block_id + '"]');
        block.find('.media_id').val(media_id);
        block.find('.media-name').text(media_name);
        block.find('.thumbnail img').attr('src', media_src);
        $('#medias-modal').modal('hide');
    });
});