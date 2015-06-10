<div id="block-template-article_list">
    <div class="form-group">
        <label>{{ trans('w-cms-laravel::pages.block_article_list_category') }}</label>
        <select name="article_list_category_id" class="article_list_category_id form-control" autocomplete="off">
            <option value="">{{ trans('w-cms-laravel::pages.choose_article_list_category') }}</option>
            @if (isset($article_categories))
                @foreach ($article_categories as $category)
                    <option value="{{ $category->ID }}">{{ $category->name }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">
        <label>{{ trans('w-cms-laravel::pages.block_article_list_number') }}</label>
        <input name="article_list_number" type="text" class="form-control article_list_number" placeholder="{{ trans('w-cms-laravel::pages.block_article_list_number') }}" value="" autocomplete="off" />
    </div>

    <div class="form-group">
        <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
        <input type="radio" value="asc" name="article_list_order" class="article_list_order_asc" checked autocomplete="off" /> {{ trans('w-cms-laravel::generic.ascending') }}
        <input type="radio" value="desc" name="article_list_order" class="article_list_order_desc" /> {{ trans('w-cms-laravel::generic.descending') }}
    </div>
</div>