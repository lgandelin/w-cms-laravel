@include ('w-cms-laravel::back.editorial.includes.fields.media_field', [
    'divID' => (isset($block)) ? 'block-' . $block->ID : 'block-media-id',
    'media' => (isset($block) && isset($block->content) && isset($block->content->media)) ? $block->content->media : null
])

@include ('w-cms-laravel::back.editorial.includes.fields.select_field', [
    'label' => trans('w-cms-laravel::pages.block_media_format'),
    'name' => 'media_format_id',
    'class' => 'media_format_id',
    'default_option_name' => trans('w-cms-laravel::pages.choose_media_format'),
    'items' => $media_formats,
    'value' => (isset($block->mediaFormatID)) ? $block->mediaFormatID : null,
    'item_property_name' => 'name',
])

@include ('w-cms-laravel::back.editorial.includes.fields.text_field', [
    'label' => trans('w-cms-laravel::pages.block_media_link'),
    'name' => 'media_link',
    'class' => 'media_link',
    'placeholder' => trans('w-cms-laravel::pages.block_media_link'),
    'value' => (isset($block)) ? $block->mediaLink : ''
])