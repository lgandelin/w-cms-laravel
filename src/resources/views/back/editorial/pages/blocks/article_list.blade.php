@include ('w-cms-laravel::back.editorial.includes.fields.select_field', [
    'label' => trans('w-cms-laravel::pages.block_article_list_category'),
    'name' => 'article_list_category_id',
    'class' => 'article_list_category_id',
    'default_option_name' => trans('w-cms-laravel::pages.choose_article_list_category'),
    'items' => isset($article_categories) ? $article_categories : null,
    'value' => (isset($block->articleListCategoryID)) ? $block->articleListCategoryID : null,
    'item_property_name' => 'name'
])

@include ('w-cms-laravel::back.editorial.includes.fields.text_field', [
    'label' => trans('w-cms-laravel::pages.block_article_list_number'),
    'name' => 'article_list_number',
    'class' => 'article_list_number',
    'placeholder' => trans('w-cms-laravel::pages.block_article_list_number'),
    'value' => (isset($block->article_list_number)) ? $block->article_list_number : ''
])

<div class="form-group">
    <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
    <input type="radio" value="asc" name="article_list_order" class="article_list_order_asc" @if (isset($block->article_list_order) && $block->article_list_order == 'asc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.ascending') }}
    <input type="radio" value="desc" name="article_list_order" class="article_list_order_desc" @if (isset($block->article_list_order) && $block->article_list_order == 'desc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.descending') }}
</div>