$(document).ready(function() {

    //Drag and drop initialization
    init_block_sortable();

    //Create block
    $('body').on('click', '.area-create-block', function() {
        var modal = $('#block-infos-modal');
        $(modal).find('.btn-valid').attr('data-area-id', $(this).attr('data-id')).attr('data-action', 'create');

        $(modal).find('.name').val('');
        $(modal).find('.width').val('');
        $(modal).find('.height').val('');
        $(modal).find('.class').val('');
        $(modal).find('.type').val('');

        $(modal).modal('show');
    });

    //Update block
    $('body').on('click', '.block-update', function() {
        var block_id = $(this).attr('data-id');
        var modal = $('#block-infos-modal');
        $(modal).find('.btn-valid').attr('data-id', block_id).attr('data-action', 'update');
        
        var block = $('.block[data-id="' + block_id + '"]');

        $.ajax({
            type: "GET",
            url: route_blocks_get_infos + '/' + block_id,
            success: function(data) {
                data = JSON.parse(data);

                var is_master = (data.block.is_master) ? data.block.is_master : 0;
                var is_ghost = (data.block.is_ghost) ? data.block.is_ghost : 0;

                $('input[name="block_is_master"]').prop('checked', false);
                $('input[name="block_is_ghost"]').prop('checked', false);
                $('input[name="block_alignment"]').prop('checked', 'left');

                if (data.success) {
                    $(modal).find('.name').val(data.block.name);
                    $(modal).find('.width').val(data.block.width);
                    $(modal).find('.height').val(data.block.height);
                    $(modal).find('.class').val(data.block.class);
                    $(modal).find('#block_alignment_' + data.block.alignment).prop('checked', true);
                    $(modal).find('.type').val(data.block.type);
                    $(modal).find('#block_is_master_' + is_master).prop('checked', true);
                    $(modal).find('#block_is_ghost_' + is_ghost).prop('checked', true);

                    $(modal).modal('show');
                } else {
                    
                }
            }
        });
    });

    //Valid block
    $('body').on('click', '#block-infos-modal .btn-valid', function() {

        if ($(this).attr('data-action') == 'create') {
            var input_data = {
                'name': $('#block-infos-modal .name').val(),
                'width': $('#block-infos-modal .width').val(),
                'height': $('#block-infos-modal .height').val(),
                'type': $('#block-infos-modal .type').val(),
                'class': $('#block-infos-modal .class').val(),
                'alignment': $('#block-infos-modal input[name="block_alignment"]:checked').val(),
                'is_master': $('#block-infos-modal input[name="block_is_master"]:checked').val(),
                'is_ghost': $('#block-infos-modal input[name="block_is_ghost"]:checked').val(),
                'area_id': $(this).attr('data-area-id'),
                '_token': $('input[name="_token"]').val()
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_blocks_create,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');

                        //Create block in "Structure" tab
                        var block_content = '<div id="b-' + data.block.ID + '" data-id="' + data.block.ID + '" class="block col-xs-' + data.block.width + ' align-' + data.block.alignment + '" data-display="0" data-width="' + data.block.width + '"><div class="block_color"><span class="title"><span class="block-name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span> [<span class="width_value">' + data.block.width + '</span>]<span data-id="' + data.block.ID + '" class="block-delete glyphicon glyphicon-remove"></span><span data-id="' + data.block.ID + '" class="block-move glyphicon glyphicon-move"></span><span data-id="' + data.block.ID + '" class="block-display block-hidden glyphicon glyphicon-eye-open"></span><span data-id="' + data.block.ID + '" class="block-update glyphicon glyphicon-pencil"></span></span></div></div>';
                        $('#structure .area[data-id="' + input_data.area_id + '"] .area_color').append(block_content);
                        init_block_sortable();

                        //Create block in "Content" tab
                        var block_content = '<div class="block" data-id="' + data.block.ID + '" data-type="' + data.block.type + '"><span class="title"><span class="block_name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span></span><div class="content">';
                    
                        if (data.block.type == 'html')
                            block_content += '<textarea class="ckeditor" id="editor' + data.block.ID + '" name="editor' + data.block.ID + '"></textarea>';
                        else if (data.block.type == 'menu')
                            block_content += $('#select_menu_template').html();
                        else if (data.block.type == 'view_file')
                            block_content += $('#view_file_template').html();
                        else if (data.block.type == 'article')
                            block_content += $('#select_article_template').html();
                        else if (data.block.type == 'article_list')
                            block_content += $('#article_category_template').html();
                        else if (data.block.type == 'media')
                            block_content += $('#select_media_template').html();

                        block_content += '<div class="submit_wrapper"><input data-id="' + data.block.ID + '" class="page-content-save-block btn btn-success" value="Submit" type="button"><input data-id="' + data.block.ID + '" class="page-content-close-block btn btn-default" value="Close" type="button"></div></div></div>';
                        $('#content .area[data-id="' + input_data.area_id + '"] > .content').append(block_content);
                        
                        if (data.block.type == 'html')
                            CKEDITOR.replace( 'editor' + data.block.ID);

                        $('#block-infos-modal').modal('hide');
                    } else {
                        
                    }
                }
            });
        } else if ($(this).attr('data-action') == 'update') {
            var block_id = $(this).attr('data-id');
            var block = $('#structure .block[data-id="' + block_id + '"]');

            var input_data = {
                'ID': block_id,
                'name': $('#block-infos-modal .name').val(),
                'width': $('#block-infos-modal .width').val(),
                'height': $('#block-infos-modal .height').val(),
                'type': $('#block-infos-modal .type').val(),
                'class': $('#block-infos-modal .class').val(),
                'alignment': $('#block-infos-modal input[name="block_alignment"]:checked').val(),
                'is_master': $('#block-infos-modal input[name="block_is_master"]:checked').val(),
                'is_ghost': $('#block-infos-modal input[name="block_is_ghost"]:checked').val(),
                '_token': $('input[name="_token"]').val()
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_blocks_update_infos,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');

                        //Update block in "Structure" tab
                        block.removeClass().addClass('block col-xs-' + input_data.width + ' align-' + input_data.alignment);
                        block.attr('data-width', input_data.width);
                        block.find('.width_value').text(input_data.width);
                        block.find('.block-name').text(input_data.name);
                        block.find('.type').text('(' + input_data.type.toUpperCase() + ')');

                        //Update block in "Content" tab                            
                        $('#content .block[data-id="' + block_id + '"]').find('.block_name').text(input_data.name);
                        $('#content .block[data-id="' + block_id + '"]').find('.type').text('(' + input_data.type + ')');

                        if ($('#content .block[data-id="' + block_id + '"]').attr('data-type') != input_data.type) {
                            $('#content .block[data-id="' + block_id + '"]').attr('data-type', input_data.type.toLowerCase());

                            var block_content = '';
                            if (input_data.type == 'html')
                                block_content += '<textarea class="ckeditor" id="editor' + input_data.ID + '" name="editor' + input_data.ID + '"></textarea>';
                            else if (input_data.type == 'menu')
                                block_content += $('#select_menu_template').html();
                            else if (input_data.type == 'view_file')
                                block_content += $('#view_file_template').html();
                            else if (input_data.type == 'article')
                                block_content += $('#select_article_template').html();
                            else if (input_data.type == 'article_list')
                                block_content += $('#article_category_template').html();
                            else if (input_data.type == 'media')
                                block_content += $('#select_media_template').html();

                            block_content += '<div class="submit_wrapper"><input data-id="' + input_data.ID + '" class="page-content-save-block btn btn-success" value="Submit" type="button"><input data-id="' + input_data.ID + '" class="page-content-close-block btn btn-default" value="Close" type="button"></div></div></div>';
                            
                            $('#content .block[data-id="' + block_id + '"] .content').html(block_content);

                            if (input_data.type == 'html')
                                CKEDITOR.replace( 'editor' + input_data.ID);
                        }
                        
                        $('#block-infos-modal').modal('hide');

                    } else {
                        
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
                'ID': block_id,
                '_token': $('input[name="_token"]').val()
            };

            $.ajax({
                type: "POST",
                url: route_blocks_delete,
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

    //Display block
    $('body').on('click', '.block-display', function() {
        var block_id = $(this).attr('data-id');
        var block = $('#structure .block[data-id="' + block_id + '"]');

        var data = {
            'ID': block_id,
            'display': ((1 + parseInt(block.attr('data-display'))) % 2),
            '_token': $('input[name="_token"]').val()
        };

        $.ajax({
            type: "POST",
            url: route_blocks_display,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    var block = $('#structure .block[data-id="' + block_id + '"]');
                    if (parseInt(block.attr('data-display')) == 0) {
                        block.find('.block-display').removeClass('block-hidden');
                        block.attr('data-display', 1);
                    } else {
                        block.find('.block-display').addClass('block-hidden');
                        block.attr('data-display', 0);
                    }
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                    $('#structure .blocks-wrapper').after(label_error);
                    label_error.fadeIn().delay(2000).fadeOut();
                }
            }
        });
    });

    //Go to content block
    $('body').on('click', '.block-go-to-content', function() {
        var block_id = $(this).attr('data-id');
        $('a[href="#content"]').click();

        var block_selector = '#content .block[data-id="' + block_id + '"]';
        $(block_selector).find('.title').trigger('click');
        
        scrollTo(block_selector);
    });
});

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
        cancel: '.child-block',
        connectWith: '.area_color',
        handle: '.block-move, .block-name',
        stop: function (event, ui) {
            var block_id = ui.item.attr('data-id');
            var area = ui.item.closest('.area_color');

            var data = {
                'block_id': block_id,
                'area_id': area.closest('.area').attr('data-id'),
                'blocks': JSON.stringify(area.sortable('toArray')),
                '_token': $('input[name="_token"]').val()
            }

            $.ajax({
                data: data,
                type: 'POST',
                url: route_blocks_update_order
            });
        },
        tolerance: 'pointer'
    });
}

function scrollTo(selector) {
    $('html, body').animate({
        scrollTop: $(selector).offset().top
    }, 500);
}