$(document).ready(function() {

    //Create
	$('form').on('click', '.btn-create', function() {

		var label = $(this).parent().find('input[name="items_label[]"]').val();
		var order = $(this).parent().find('input[name="items_order[]"]').val();
        var page_id = $(this).parent().find('select[name="items_page[]"]').val();
        var menu_id = $('input[name="ID"]').val();

		var data = {
            'menuID': menu_id,
			'label': label,
			'order': parseInt(order),
            'pageID': page_id
		};

		$.ajax({
			type: "POST",
			url: route_menus_add_item,
			data: data,
			success: function(data) {
                data = JSON.parse(data);

				if (data.success) {

                    $('.btn-create').parent().find('input[name="items_label[]"]').val('');
                    $('.btn-create').parent().find('input[name="items_order[]"]').val('');
                    $('.btn-create').parent().find('select').val('');

                    var item_id = data.id;

                    var wrapper = $('.new-menu-pattern').clone();
                    wrapper.removeClass('new-menu-pattern').show();
                    wrapper.find('input[name="items_label[]"]').val(label);
                    wrapper.find('input[name="items_order[]"]').val(order);
                    wrapper.find('select').val(page_id);
                    wrapper.find('.btn-update').attr('data-item-id', item_id);
                    wrapper.find('.btn-delete').attr('data-item-id', item_id);

                    $('.new-menu-pattern').before(wrapper);
                } else {
                    alert(data.error);
                }
			}
		});
	});

    //Update
    $('form').on('click', '.btn-update', function() {

        var label = $(this).parent().find('input[name="items_label[]"]').val();
        var order = $(this).parent().find('input[name="items_order[]"]').val();
        var page_id = $(this).parent().find('select[name="items_page[]"]').val();
        var menu_id = $('input[name="ID"]').val();
        var item_id = $(this).attr('data-item-id');

        var data = {
            'menuID': menu_id,
            'ID': item_id,
            'label': label,
            'order': parseInt(order),
            'pageID': page_id
        };

        $.ajax({
            type: "POST",
            url: route_menus_update_item,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {

                } else {
                    alert(data.error);
                }
            }
        });
    });

    //Delete
    $('form').on('click', '.btn-delete', function() {

        var menu_id = $('input[name="ID"]').val();
        var item_id = $(this).attr('data-item-id');

        var data = {
            'menuID': menu_id,
            'ID': item_id
        };

        $.ajax({
            type: "POST",
            url: route_menus_delete_item,
            data: data,
            success: function(data) {
                data = JSON.parse(data);

                if (data.success) {
                    $('.btn-delete[data-item-id="' + item_id + '"]').parent().remove();
                } else {
                    alert(data.error);
                }
            }
        });
    });
});