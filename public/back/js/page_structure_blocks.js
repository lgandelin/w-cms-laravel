$(document).ready(function() {

    //Drag and drop initialization
    init_block_sortable();

    //Close block form
    $('.block-form .btn-close').on( "click", function() {
        $('.block-form').hide();
    });
    
    //Create block
    $('body').on('click', '.area-create-block', function() {
        $('.block-form .btn-valid').attr('data-area-id', $(this).attr('data-id')).attr('data-action', 'create');
        $('.area-form').hide();
        $('.block-form').show();
    });

    //Update block
    $('body').on('click', '.block-update', function() {
        var block_id = $(this).attr('data-id');
        $('.block-form .btn-valid').attr('data-id', block_id).attr('data-action', 'update');
        $('.area-form').hide();
        
        var block = $('.block[data-id="' + block_id + '"]');

        $.ajax({
            type: "GET",
            url: route_blocks_get_infos + '/' + block_id,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $('.block-form .name').val(data.block.name);
                    $('.block-form .width').val(data.block.width);
                    $('.block-form .height').val(data.block.height);
                    $('.block-form .class').val(data.block.class);
                    $('.block-form .type').val(data.block.type);

                    $('.block-form').show();
                } else {
                    
                }
            }
        });
    });

    //Valid block
    $('body').on('click', '.block-form .btn-valid', function() {

        if ($(this).attr('data-action') == 'create') {
            var input_data = {
                'name': $('.block-form .name').val(),
                'width': $('.block-form .width').val(),
                'height': $('.block-form .height').val(),
                'type': $('.block-form .type').val(),
                'class': $('.block-form .class').val(),
                'area_id': $(this).attr('data-area-id')
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
                        var block_content = '<div id="b-' + data.block.ID + '" data-id="' + data.block.ID + '" class="block col-xs-' + data.block.width + '" data-display="0"><div class="block_color"><span class="title"><span class="name">' + data.block.name + '</span> <span class="type">(' + data.block.type + ')</span> [<span class="width_value">' + data.block.width + '</span>]<span data-id="' + data.block.ID + '" class="block-delete glyphicon glyphicon-remove"></span><span data-id="' + data.block.ID + '" class="block-move glyphicon glyphicon-move"></span><span data-id="' + data.block.ID + '" class="block-display block-hidden glyphicon glyphicon-eye-open"></span><span data-id="' + data.block.ID + '" class="block-update glyphicon glyphicon-pencil"></span></span></div></div>';
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

                        block_content += '<div class="submit_wrapper"><input data-id="' + data.block.ID + '" class="page-content-save-block btn btn-success" value="Submit" type="button"><input data-id="' + data.block.ID + '" class="page-content-close-block btn btn-default" value="Close" type="button"></div></div></div>';
                        $('#content .area[data-id="' + input_data.area_id + '"] > .content').append(block_content);
                        
                        if (data.block.type == 'html')
                            CKEDITOR.replace( 'editor' + data.block.ID);

                    } else {
                        
                    }
                }
            });
        } else if ($(this).attr('data-action') == 'update') {
            var block_id = $(this).attr('data-id');
            var block = $('#structure .block[data-id="' + block_id + '"]');

            var input_data = {
                'ID': block_id,
                'name': $('.block-form .name').val(),
                'width': $('.block-form .width').val(),
                'height': $('.block-form .height').val(),
                'type': $('.block-form .type').val(),
                'class': $('.block-form .class').val()
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
                        $('.block-form').hide();

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
            'display': ((1 + parseInt(block.attr('data-display'))) % 2)
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
                url: route_blocks_update_order
            });
        },
        tolerance: 'intersect'
    });
}