$(document).ready(function() {

	//Drag and drop initialization
    init_area_sortable();

    //Close area form
    $('.area-form .btn-close').on( "click", function() {
        $('.area-form').hide();
    });

    //Create area
    $('body').on('click', '.page-content-create-area', function() {
        $('.area-form .btn-valid').attr('data-page-id', $(this).attr('data-id')).attr('data-action', 'create');
        $('.area-form').show();
    });

    //Update area
    $('body').on('click', '.area-update', function() {
        var area_id = $(this).attr('data-id');
        $('.area-form .btn-valid').attr('data-id', area_id).attr('data-action', 'update');

        var area = $('.area[data-id="' + area_id + '"]');

        $.ajax({
            type: "GET",
            url: route_areas_get_infos + '/' + area_id,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $('.area-form .name').val(data.area.name);
                    $('.area-form .width').val(data.area.width);
                    $('.area-form .height').val(data.area.height);
                    $('.area-form .class').val(data.area.class);

                    $('.area-form').show();
                } else {
                    
                }
            }
        });
    });

    //Valid area
    $('body').on('click', '.area-form .btn-valid', function() {
        if ($(this).attr('data-action') == 'create') {
            var input_data = {
                'name': $('.area-form .name').val(),
                'width': $('.area-form .width').val(),
                'height': $('.area-form .height').val(),
                'class': $('.area-form .class').val(),
                'page_id': $(this).attr('data-page-id')
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_areas_create,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');

                        $('.area-form').hide();
                        $('.area-form .name').val('');
                        $('.area-form .width').val('');
                        $('.area-form .height').val('');
                        $('.area-form .class').val('');

                        //Create area in "Structure" tab
                        var area_content = '<div id="a-'+ data.area.ID + '" data-width="' + data.area.width + '" data-id="' + data.area.ID + '" class="area col-xs-' + data.area.width + '"><div class="area_color"><span class="title"><span class="area_name">' + data.area.name + '</span> <span class="area_width">[<span class="width_value">' + data.area.width + '</span>]</span><span data-id="' + data.area.ID + '" class="area-delete glyphicon glyphicon-remove"></span><span data-id="' + data.area.ID + '" class="area-move glyphicon glyphicon-move"></span><span data-id="' + data.area.ID + '" class="area-display glyphicon glyphicon-eye-open"></span><span data-id="' + data.area.ID + '" class="area-update glyphicon glyphicon-pencil"></span><span data-id="' + data.area.ID + '" class="area-create-block glyphicon glyphicon-plus"></span></span></div></div>';
                        $('#structure > .areas-wrapper').append(area_content);
                        init_area_sortable();
                        init_block_sortable();

                        //Create area in "Content" tab
                        var area_content = '<div class="area" data-id="' + data.area.ID + '"><span class="title"><span class="area_name">' + data.area.name + '</span></span><div class="content"></div></div>';
                        $('#content .form-group:last-child').append(area_content);
                    } else {
                        
                    }
                }
            });
        } else if ($(this).attr('data-action') == 'update') {
            var area_id = $(this).attr('data-id');
            var area = $('#structure .area[data-id="' + area_id + '"]');

            var input_data = {
                'ID': area_id,
                'name': $('.area-form .name').val(),
                'width': $('.area-form .width').val(),
                'class': $('.area-form .class').val()
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_areas_update_infos,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');
                        $('.area-form').hide();

                        //Update area in "Structure" tab
                        area.removeClass().addClass('area col-xs-' + input_data.width);
                        area.attr('data-width', input_data.width);
                        area.find('.area_width .width_value').text(input_data.width);
                        area.find('.area_name').text(input_data.name);

                        //Update area in "Content" tab
                        $('#content .area[data-id="' + area_id + '"]').find('.area_name').text(input_data.name);
                    } else {
                        
                    }
                }
            });
        }
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
                url: route_areas_delete,
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

    //Display area
    $('body').on('click', '.area-display', function() {
        var area_id = $(this).attr('data-id');
        var area = $('#structure .area[data-id="' + area_id + '"]');
        
        var data = {
            'ID': area_id,
            'display': ((1 + parseInt(area.attr('data-display'))) % 2)
        };

        $.ajax({
            type: "POST",
            url: route_areas_display,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    var area = $('#structure .area[data-id="' + area_id + '"]');
                    if (parseInt(area.attr('data-display')) == 0) {
                        area.find('.area-display').removeClass('area-hidden');
                        area.attr('data-display', 1);
                    } else {
                        area.find('.area-display').addClass('area-hidden');
                        area.attr('data-display', 0);
                    }
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                    $('#structure .areas-wrapper').after(label_error);
                    label_error.fadeIn().delay(2000).fadeOut();
                }
            }
        });
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
                url: route_areas_update_order
            });
        },
        tolerance: 'intersect'
    });
}