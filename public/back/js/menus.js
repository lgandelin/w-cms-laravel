$(document).ready(function() {

    //Close menu item form
    $('.menu-item-form .btn-close').click(function() {
        $('.menu-item-form').hide();
    });

    //Create menu item
    $('body').on('click', '.btn-create-menu-item', function() {
        $('.menu-item-form .btn-valid').attr('data-action', 'create');
        $('.menu-item-form').show();
    });

    //Update menu item
    $('body').on('click', '.menu-item-update', function() {

        var menu_item_id = $(this).attr('data-id');
        $('.menu-item-form .btn-valid').attr('data-id', menu_item_id).attr('data-action', 'update');

        $.ajax({
            type: "GET",
            url: route_menu_items_get_infos + '/' + menu_item_id,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $('.menu-item-form .menu-item-label').val(data.menu_item.label);
                    $('.menu-item-form .menu-item-class').val(data.menu_item.class);
                    $('.menu-item-form .page_id').val(data.menu_item.page_id);
                    $('.menu-item-form .menu-item-external-url').val(data.menu_item.external_url);
                    
                    $('.menu-item-form').show();
                } else {
                    
                }
            }
        });
    });

    //Valid menu item
    $('.menu-item-form .btn-valid').click(function() {
        if ($(this).attr('data-action') == 'create') {
            var input_data = {
                'menuID': $('.menu-id').val(),
                'label': $('.menu-item-form .menu-item-label').val(),
                'class': $('.menu-item-form .menu-item-class').val(),
                'pageID': $('.menu-item-form .page_id').val(),
                'externalURL': $('.menu-item-form .menu-item-external-url').val(),
                'display': 0
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_menu_items_create,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');

                        $('.menu-item-form').hide();
                        $('.menu-item-form .menu-item-label').val('');
                        $('.menu-item-form .menu-item-class').val('');
                        $('.menu-item-form .page_id').val('');
                        $('.menu-item-form .menu-item-external-url').val('');

                        //Create menu item
                        var menu_item_content = '<div id="mi-' + data.menu_item.ID + '" class="menu_item" data-display="0"><span class="title"><span class="menu_item_label">' + data.menu_item.label + '</span><span data-id="' + data.menu_item.ID + '" class="menu-item-delete glyphicon glyphicon-remove"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-move glyphicon glyphicon-move"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-display menu-item-hidden glyphicon glyphicon-eye-open"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-update glyphicon glyphicon-pencil"></span></span></div>';
                        $('.menu-items-wrapper').append(menu_item_content);
                    } else {
                        
                    }
                }
            });
        } else if ($(this).attr('data-action') == 'update') {
            var input_data = {
                'ID': $(this).attr('data-id'),
                'label': $('.menu-item-form .menu-item-label').val(),
                'class': $('.menu-item-form .menu-item-class').val(),
                'pageID': $('.menu-item-form .page_id').val(),
                'externalURL': $('.menu-item-form .menu-item-external-url').val(),
            };

            var button = $(this);
            button.val('Saving ...');

            $.ajax({
                type: "POST",
                url: route_menu_items_update_infos,
                data: input_data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        button.val('Submit');

                        $('.menu-item-form').hide();
                        $('.menu-item-form .menu-item-label').val('');
                        $('.menu-item-form .menu-item-class').val('');
                        $('.menu-item-form .page_id').val('');
                        $('.menu-item-form .menu-item-external-url').val('');

                        $('#mi-' + input_data.ID + ' .menu_item_label').text(input_data.label);
                    } else {
                        
                    }
                }
            });
        }
    });

    //Display menu_item
    $('body').on('click', '.menu-item-display', function() {
        var menu_item_id = $(this).attr('data-id');
        var menu_item = $('.menu_item[id="mi-' + menu_item_id + '"]');
        
        var data = {
            'ID': menu_item_id,
            'display': ((1 + parseInt(menu_item.attr('data-display'))) % 2)
        };

        $.ajax({
            type: "POST",
            url: route_menu_items_display,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    var menu_item = $('.menu_item[id="mi-' + menu_item_id + '"]');
                    if (parseInt(menu_item.attr('data-display')) == 0) {
                        menu_item.find('.menu-item-display').removeClass('menu-item-hidden');
                        menu_item.attr('data-display', 1);
                    } else {
                        menu_item.find('.menu-item-display').addClass('menu-item-hidden');
                        menu_item.attr('data-display', 0);
                    }
                } else {
                    var label_error = $('<p class="alert alert-danger">' + data.error + '</p>');
                    $('.menu-items-wrapper').after(label_error);
                    label_error.fadeIn().delay(2000).fadeOut();
                }
            }
        });
    });

    //Delete menu item
    $('body').on('click', '.menu-item-delete', function() {

        if (confirm('Are you sure that you want to delete this item ?')) {
            var menu_item_id = $(this).attr('data-id');
            
            var data = {
                'ID': menu_item_id
            };

            $.ajax({
                type: "POST",
                url: route_menu_items_delete,
                data: data,
                success: function(data) {
                    data = JSON.parse(data);

                    if (data.success) {
                        $('.menu_item[id="mi-' + menu_item_id + '"]').remove();
                    } else {
                       
                    }
                }
            });
        }
    });
    
    init_menu_items_sortable();
});

function init_menu_items_sortable() {
    $( ".menu-items-wrapper" ).sortable({
        placeholder: 'sortable-placeholder menu_item',
        items: '.menu_item',
        handle: '.menu-item-move',
        update: function (event, ui) {
            var data = $(this).sortable('toArray');

            var data = {
                'menu_items': JSON.stringify($(this).sortable('toArray'))
            }

            $.ajax({
                data: data,
                type: 'POST',
                url: route_menu_items_update_order
            });
        },
        tolerance: 'intersect'
    });
}