$(document).ready(function() {

    /********************************
    * CONTENT
    ********************************/

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
            url: route_pages_update_page_infos,
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
            url: route_pages_update_page_seo,
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
        var textarea_id = $('.block[data-id="' + block_id + '"] textarea').attr('id');
        var html = CKEDITOR.instances[textarea_id].getData();

        var data = {
            'ID': block_id,
            'html': html
        };

        var button = $(this);
        button.val('Saving ...');

        $.ajax({
            type: "POST",
            url: route_pages_update_block_content,
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







    /********************************
    * STRUCTURE
    ********************************/
    init_area_sortable();
    init_block_sortable();

    //Create area
    $('body').on('click', '.page-content-create-area', function() {
        $('.create-area-form, .create-block-form').hide();
        $('.update-area-form, .update-block-form').hide();

        $('.create-area-form').show();
    });

    $('body').on('click', '.page-content-valid-create-area', function() {

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
            url: route_pages_create_area,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    button.val('Submit');

                    $('.create-area-form').hide();
                    $('.create-area-form .name').val('');
                    $('.create-area-form .width').val('');
                    $('.create-area-form .height').val('');
                    $('.create-area-form .class').val('');

                    //Create area in "Structure" tab
                    var area_content = '<div id="a'+ data.area.ID + '" data-width="' + data.area.width + '" data-id="' + data.area.ID + '" class="area col-xs-' + data.area.width + '"><div class="area_color"><span class="title"><span class="area_name">' + data.area.name + '</span> <span class="area_width">[<span class="width_value">' + data.area.width + '</span>]</span><span data-id="' + data.area.ID + '" class="area-delete glyphicon glyphicon-remove"></span><span data-id="' + data.area.ID + '" class="area-update glyphicon glyphicon-pencil"></span><span data-id="' + data.area.ID + '" class="area-move glyphicon glyphicon-move"></span><span data-id="' + data.area.ID + '" class="area-create-block glyphicon glyphicon-plus"></span></span></div></div>';
                    $('#structure > .areas-wrapper').append(area_content);
                    init_area_sortable();

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
            url: route_pages_create_block,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    button.val('Submit');
                    $('.create-block-form').hide();

                    //Create block in "Structure" tab
                    var block_content = '<div id="b' + data.block.ID + '" data-id="' + data.block.ID + '" class="block col-xs-' + data.block.width + '"><div class="block_color"><span class="title"><span class="name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span> [<span class="width_value">' + data.block.width + '</span>]<span data-id="' + data.block.ID + '" class="block-delete glyphicon glyphicon-remove"></span><span data-id="' + data.block.ID + '" class="block-move glyphicon glyphicon-move"></span><span data-id="' + data.block.ID + '" class="block-update glyphicon glyphicon-pencil"></span></span></div></div>';
                    $('#structure .area[data-id="' + input_data.area_id + '"] .area_color').append(block_content);
                    init_block_sortable();

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

        $.ajax({
            type: "GET",
            url: route_pages_get_block_infos + '/' + block_id,
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
            url: route_pages_update_block_infos,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    button.val('Submit');
                    $('.update-block-form').hide();

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

        $.ajax({
            type: "GET",
            url: route_pages_get_area_infos + '/' + area_id,
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
            url: route_pages_update_area_infos,
            data: input_data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    button.val('Submit');
                    $('.update-area-form').hide();

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
            
            var data = {
                'ID': area_id
            };

            $.ajax({
                type: "POST",
                url: route_pages_delete_area,
                data: data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        $('.area[data-id="' + area_id + '"]').remove();
                    } else {
                        var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                        $('#structure .areas-wrapper').after(label_error);
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
            
            var data = {
                'ID': block_id
            };

            $.ajax({
                type: "POST",
                url: route_pages_delete_block,
                data: data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        $('.block[data-id="' + block_id + '"]').remove();
                    } else {
                        var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                        $('#structure .areas-wrapper').after(label_error);
                        label_error.fadeIn().delay(2000).fadeOut();
                    }
                }
            });
        }
    });

});





function init_area_sortable() {
     $( ".areas-wrapper" ).sortable({
        placeholder: 'sortable-placeholder area',
        items: '.area',
        start: function(event, ui) {
            var placeholder = ui.placeholder;
            var width = ui.item.attr('data-width');
            placeholder.addClass('col-xs-' + width);
            placeholder.html('<div class="area_color"></div>');
        },
        handle: '.area-move',
        update: function (event, ui) {
            var data = $(this).sortable('toArray');

            var data = {
                'areas': JSON.stringify($(this).sortable('toArray'))
            }

            $.ajax({
                data: data,
                type: 'POST',
                url: route_pages_update_areas_order
            });
        }
    });
}

function init_block_sortable() {
    $('.area_color').sortable({
        placeholder: 'sortable-placeholder block',
        items: '.block',
        start: function(event, ui) {
            var placeholder = ui.placeholder;
            var width = ui.item.attr('data-width');
            placeholder.addClass('col-xs-' + width);
            placeholder.html('<div class="block_color"></div>');
        },
        connectWith: '.area_color',
        handle: '.block-move',
        stop: function (event, ui) {
            var block_id = ui.item.attr('data-id');
            var area = ui.item.closest('.area_color');

            var data = {
                'block_id': block_id,
                'area_id': area.closest('.area').attr('data-id'),
                'blocks': JSON.stringify(area.sortable('toArray'))
            }

            $.ajax({
                data: data,
                type: 'POST',
                url: route_pages_update_blocks_order
            });
        }
    });
}