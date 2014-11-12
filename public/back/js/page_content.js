$(document).ready(function() {

	//Save page infos
    $('.page-content-save-infos').click(function() {
        var page_id = $(this).attr('data-id');
        var name = $('#name').val();
        var identifier = $('#identifier').val();

        var data = {
            'ID': page_id,
            'name': name,
            'identifier': identifier
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
            'meta_keywords': meta_keywords
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
        
        var html, menu_id, view_file, article_id;

        if (block.attr('data-type') == 'html') {
            var textarea_id = $('.block[data-id="' + block_id + '"] textarea').attr('id');
            html = CKEDITOR.instances[textarea_id].getData();    
        } else if (block.attr('data-type') == 'menu') {
            menu_id = $('.block[data-id="' + block_id + '"] .menu_id').val();
        } else if (block.attr('data-type') == 'view_file') {
            var view_file = $('.block[data-id="' + block_id + '"] .view_file').val();
        } else if (block.attr('data-type') == 'article') {
            var article_id = $('.block[data-id="' + block_id + '"] .article_id').val();
            alert(article_id);
        }

        var data = {
            'ID': block_id,
            'html': html,
            'menu_id': menu_id,
            'view_file': view_file,
            'article_id': article_id
        };

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

    $('body').on('click', '.area > .title, .block > .title', function() {
        $(this).next().toggle();
    });

    $('body').on('click', '.page-content-close-block', function() {
        $(this).closest('.content').hide();
    });
});