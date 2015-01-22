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
});