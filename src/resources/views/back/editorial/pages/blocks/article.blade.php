<div class="form-group">
    <label>{{ trans('w-cms-laravel::pages.block_article') }}</label>
    <select name="article_id" class="article_id form-control" autocomplete="off">
        <option value="">{{ trans('w-cms-laravel::pages.choose_article') }}</option>
        @if (isset($articles))
            @foreach ($articles as $article)
                <option value="{{ $article->ID }}" @if (isset($block->article_id) && $block->article_id == $article->ID) selected="selected" @endif>{{ $article->title }}</option>
            @endforeach
        @endif
    </select>
</div>