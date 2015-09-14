@include ('w-cms-laravel::back.editorial.includes.fields.select_field', [
    'label' => trans('w-cms-laravel::pages.block_article'),
    'name' => 'article_id',
    'class' => 'article_id',
    'default_option_name' => trans('w-cms-laravel::pages.choose_article'),
    'items' => isset($articles) ? $articles : null,
    'value' => (isset($block->articleID)) ? $block->articleID : null,
    'item_property_name' => 'title'
])