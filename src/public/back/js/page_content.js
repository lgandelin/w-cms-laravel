$(document).ready(function() {

    //Save page infos
    $('.page-content-save-infos').click(function() {
        var page_id = $(this).attr('data-id');
        var name = $('#name').val();
        var identifier = $('#identifier').val();
        var is_master = $('input[name="is_master"]:checked').val();
        var is_visible = $('input[name="is_visible"]:checked').val();

        var data = {
            'ID': page_id,
            'name': name,
            'identifier': identifier,
            'is_master': is_master,
            'is_visible': is_visible,
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
        var is_indexed = $('input[name=is_indexed]:checked').val();

        var data = {
            'ID': page_id,
            'uri': uri,
            'meta_title': meta_title,
            'meta_description': meta_description,
            'meta_keywords': meta_keywords,
            'is_indexed': (is_indexed == "true"),
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
            'type' : block.attr('data-type'),
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

                if (data.new_page_version) {
                    reload_page_new_version();
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

    $('body').on('click', '.btn-publish', function() {
        var data = {
            'uri': $(this).data('page-uri'),
            '_token': $('input[name="_token"]').val()
        };

        $.ajax({
            type: "POST",
            url: route_pages_clear_cache,
            data: data,
            success: function(data) {
            }
        });
    });
});