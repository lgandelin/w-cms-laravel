var columns = 12;

$(document).ready(function() {

    //Drag and drop initialization
    init_area_sortable();
    init_area_resizable();

    //Create area
    $('body').on('click', '.page-content-create-area', function() {
        var modal = $('#area-infos-modal');
        $(modal).find('.btn-valid').attr('data-page-id', $(this).attr('data-id')).attr('data-action', 'create');

        $(modal).find('.name').val('');
        $(modal).find('.width').val('');
        $(modal).find('.height').val('');
        $(modal).find('.class').val('');

        $(modal).modal('show');
    });

    //Update area
    $('body').on('click', '.area-update', function() {
        var area_id = $(this).data('id');

        var modal = $('#area-infos-modal');
        $(modal).find('.btn-valid').attr('data-id', area_id).attr('data-action', 'update');

        $.ajax({
            type: "GET",
            url: route_areas_get_infos + '/' + area_id,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $(modal).find('.name').val(data.area.name);
                    $(modal).find('.width').val(data.area.width);
                    $(modal).find('.height').val(data.area.height);
                    $(modal).find('.class').val(data.area.class);
                    $(modal).find('#area_is_master_' + data.area.is_master).attr('checked', 'checked');

                    $(modal).modal('show');
                } else {

                }
            }
        });
    });

    //Valid area
    $('body').on('click', '#area-infos-modal .btn-valid', function() {
        if ($(this).attr('data-action') == 'create') {
            var input_data = {
                'name': $('#area-infos-modal .name').val(),
                'width': $('#area-infos-modal .width').val(),
                'height': $('#area-infos-modal .height').val(),
                'class': $('#area-infos-modal .class').val(),
                'is_master': $('#area-infos-modal input[name="area_is_master"]:checked').val(),
                'page_id': $(this).attr('data-page-id'),
                'order': 999,
                'display': 1,
                '_token': $('input[name="_token"]').val()
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

                        //Create area in "Structure" tab
                        var area_content = '<div id="a-'+ data.area.ID + '" data-width="' + data.area.width + '" data-id="' + data.area.ID + '" class="area col-xs-' + data.area.width + '" data-display="1"><div class="area_color"><span class="title"><span class="area-name">' + data.area.name + '</span> <span class="width_value">' + data.area.width + '</span><span data-id="' + data.area.ID + '" class="area-delete glyphicon glyphicon-remove"></span><span style="display: none" data-id="' + data.area.ID + '" class="area-move glyphicon glyphicon-move"></span><span data-id="' + data.area.ID + '" class="area-display glyphicon glyphicon-eye-open"></span><span data-id="' + data.area.ID + '" class="area-update glyphicon glyphicon-pencil"></span><span data-id="' + data.area.ID + '" class="area-create-block glyphicon glyphicon-plus"></span></span></div></div>';
                        $('#structure > .areas-wrapper').append(area_content);
                        init_area_sortable();
                        init_area_resizable();
                        init_block_sortable();

                        //Create area in "Content" tab
                        var area_content = '<div class="area" data-id="' + data.area.ID + '"><span class="title"><span class="area_name">' + data.area.name + '</span></span><div class="content"></div></div>';
                        $('#content .form-group:last-child').append(area_content);

                        //Close the modal
                        $('#area-infos-modal').modal('hide');
                    } else {

                    }
                }
            });
        } else if ($(this).attr('data-action') == 'update') {
            var area_id = $(this).attr('data-id');
            var area = $('#structure .area[data-id="' + area_id + '"]');

            var input_data = {
                'ID': area_id,
                'name': $('#area-infos-modal .name').val(),
                'width': $('#area-infos-modal .width').val(),
                'class': $('#area-infos-modal .class').val(),
                'is_master': $('#area-infos-modal input[name="area_is_master"]:checked').val(),
                '_token': $('input[name="_token"]').val()
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

                        //Update area in "Structure" tab
                        area.removeClass().addClass('area col-xs-' + input_data.width);
                        area.attr('data-width', input_data.width);
                        area.find('.width_value').text(input_data.width);
                        area.find('.area-name').text(input_data.name);

                        //Update area in "Content" tab
                        $('#content .area[data-id="' + area_id + '"]').find('.area_name').text(input_data.name);

                        //Close the modal
                        $('#area-infos-modal').modal('hide');
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
                'ID': area_id,
                '_token': $('input[name="_token"]').val()
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
            'display': ((1 + parseInt(area.attr('data-display'))) % 2),
            '_token': $('input[name="_token"]').val()
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
            var height = ui.item.height();
            placeholder.addClass('col-xs-' + width).html('<div class="area_color" style="height:' + height + 'px"></div>');
        },
        cancel: '.child-area',
        handle: '.area-move, .area-name',
        update: function (event, ui) {
            var data = $(this).sortable('toArray');

            var data = {
                'areas': JSON.stringify($(this).sortable('toArray')),
                '_token': $('input[name="_token"]').val()
            }

            $.ajax({
                data: data,
                type: 'POST',
                url: route_areas_update_order
            });
        },
        tolerance: 'pointer'
    });
}

function init_area_resizable() {
    $('#structure .area').resizable({
        containment: ".areas-wrapper",
        handles: "e",
        autoHide: true,
        resize: function(e, ui) {
            var area = ui.element;
            var parent = area.parent();
            var width = Math.ceil((area.width() / parent.width()) * columns);

            if (width < 2) width = 2;
            area.removeClass('col-xs-' + area.attr('data-width')).addClass('col-xs-' + width);
            area.attr('data-width', width);
            area.find('.width_value').first().text(width);
            area.removeAttr('style');
        },
        stop: function(e, ui) {
            var area = ui.element;
            var input_data = {
                'ID': area.attr('data-id'),
                'width': area.attr('data-width'),
                '_token': $('input[name="_token"]').val()
            }
            $.ajax({
                type: "POST",
                url: route_areas_update_infos,
                data: input_data,
            });
        }
    });
}