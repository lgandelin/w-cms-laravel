$(document).ready(function() {

    $('.menu-close-create-menu-item').click(function() {
        $('.create-menu-item-form').hide();
    });

    $('.menu-close-update-menu-item').click(function() {
        $('.update-menu-item-form').hide();
    });

    //Create menu item
    $('body').on('click', '.btn-create-menu-item', function() {
        $('.create-menu-item-form, .update-menu-item-form').hide();

        $('.create-menu-item-form').show();
    });

    $('.menu-valid-create-menu-item').click(function() {
        var input_data = {
            'menuID': $('.menu-id').val(),
            'label': $('.create-menu-item-form .menu-item-label').val(),
            'class': $('.create-menu-item-form .menu-item-class').val(),
            'pageID': $('.create-menu-item-form .page_id').val(),
            'externalURL': $('.create-menu-item-form .menu-item-external-url').val(),
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

                    $('.create-menu-item-form').hide();
                    $('.create-menu-item-form .menu-item-label').val('');
                    $('.create-menu-item-form .menu-item-class').val('');
                    $('.create-menu-item-form .page_id').val('');
                    $('.create-menu-item-form .menu-item-external-url').val('');

                    //Create menu item
                    var menu_item_content = '<div id="mi-' + data.menu_item.ID + '" class="menu_item" data-display="0"><span class="title"><span class="menu_item_label">' + data.menu_item.label + '</span><span data-id="' + data.menu_item.ID + '" class="menu-item-delete glyphicon glyphicon-remove"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-move glyphicon glyphicon-move"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-display menu-item-hidden glyphicon glyphicon-eye-open"></span><span data-id="' + data.menu_item.ID + '" class="menu-item-update glyphicon glyphicon-pencil"></span></span></div>';
                    $('.menu-items-wrapper').append(menu_item_content);
                } else {
                    
                }
            }
        });
    });

    //Update menu item
    $('body').on('click', '.menu-item-update', function() {
        $('.create-menu-item-form, .create-block-form').hide();
        $('.update-menu-item-form, .update-block-form').hide();

        var menu_item_id = $(this).attr('data-id');
        $('.menu-valid-update-menu-item').attr('data-id', menu_item_id);

        $.ajax({
            type: "GET",
            url: route_menu_items_get_infos + '/' + menu_item_id,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $('.update-menu-item-form .menu-item-label').val(data.menu_item.label);
                    $('.update-menu-item-form .menu-item-class').val(data.menu_item.class);
                    $('.update-menu-item-form .page_id').val(data.menu_item.page_id);
                    $('.update-menu-item-form .menu-item-external-url').val(data.menu_item.external_url);
                    
                    $('.update-menu-item-form').show();
                } else {
                    
                }
            }
        });
    });

    //Valid update menu item
    $('body').on('click', '.menu-valid-update-menu-item', function() {
        var input_data = {
            'ID': $(this).attr('data-id'),
            'label': $('.update-menu-item-form .menu-item-label').val(),
            'class': $('.update-menu-item-form .menu-item-class').val(),
            'pageID': $('.update-menu-item-form .page_id').val(),
            'externalURL': $('.update-menu-item-form .menu-item-external-url').val(),
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

                    $('.update-menu-item-form').hide();
                    $('.update-menu-item-form .menu-item-label').val('');
                    $('.update-menu-item-form .menu-item-class').val('');
                    $('.update-menu-item-form .page_id').val('');
                    $('.update-menu-item-form .menu-item-external-url').val('');

                    $('#mi-' + input_data.ID + ' .menu_item_label').text(input_data.label);
                } else {
                    
                }
            }
        });
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