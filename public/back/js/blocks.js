$(document).ready(function() {

	$('select[name="type"]').change(function() {
		var block_content = '';

		if ($(this).val() == 'html')
            block_content += '<textarea class="ckeditor" id="editor-html" name="html"></textarea>';
        else if ($(this).val() == 'menu')
            block_content += $('#select_menu_template').html();
        else if ($(this).val() == 'view_file')
            block_content += $('#view_file_template').html();
        else if ($(this).val() == 'article')
            block_content += $('#select_article_template').html();
        else if ($(this).val() == 'article_list')
            block_content += $('#article_category_template').html();
        else if ($(this).val() == 'media')
            block_content += $('#select_media_template').html();

		$('.content').empty().append(block_content);
		
        if ($(this).val() == 'html')
			CKEDITOR.replace('html');

	});

    //Medias modal
    $('body').on('click', '.open-medias-modal', function() {
        var modal = $('#medias-modal');
        var block_id = $('input[name="ID"]').val();
        modal.attr('data-block-id', block_id);
        modal.attr('data-name', $(this).attr('data-name'));
        modal.attr('data-src', $(this).attr('data-src'));
        $(modal).modal('show');
    });

    $('body').on('click', '.popup-media-id', function(e) {
        e.preventDefault();

        var media_id = $(this).attr('data-id');
        var media_name = $(this).attr('data-name');
        var media_src = $(this).attr('data-src');
        var block_id = $('#medias-modal').attr('data-block-id');

        var block = $('form .content');
        block.find('.media_id').val(media_id);
        block.find('.media-name').text(media_name);
        block.find('.thumbnail img').attr('src', media_src);
        $('#medias-modal').modal('hide');
    });
});