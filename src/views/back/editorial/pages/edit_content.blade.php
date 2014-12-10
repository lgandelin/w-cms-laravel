<!-- CONTENT -->
<div class="tab-pane active" id="content">

    <!-- Name -->
    <div class="form-group">
        <label for="name">{{ trans('w-cms-laravel::pages.name') }}</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::pages.name') }}" value="{{ $page->name }}" autocomplete="off" />
    </div>
    <!-- Name -->

    <!-- Identifier -->
    <div class="form-group">
        <label for="identifier">{{ trans('w-cms-laravel::pages.identifier') }}</label>
        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::pages.identifier') }}" value="{{ $page->identifier }}" autocomplete="off" />
    </div>
    <!-- Identifier -->

    <!-- Save -->
    <div class="form-group">
        <input type="button" data-id="{{ $page->ID }}" class="page-content-save-infos btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
        <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
    </div>
    <!-- Save -->

    <!-- Blocks content -->
    <div class="form-group">
        <p><strong>{{ trans('w-cms-laravel::pages.content') }}</strong></p>

        @if (isset($page->areas))
        @foreach ($page->areas as $area)
        <div class="area" data-id="{{ $area->ID }}">
            <span class="title"><span class="area_name">{{ $area->name }}</span><span class="glyphicon glyphicon-chevron-up opening-status"></span></span>

            <div class="content">
                @foreach ($area->blocks as $block)
                <div class="block" data-id="{{ $block->ID }}" data-type="{{ $block->type }}">
                    <span class="title"><span class="block_name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span><span class="glyphicon glyphicon-chevron-down opening-status"></span></span>
                    <div class="content">
                        @if ($block->type == 'html')
                            <textarea class="ckeditor" id="editor{{ $block->ID }}" name="editor{{ $block->ID }}">{{ $block->html }}</textarea>
                        @elseif ($block->type == 'menu')
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_menu') }}</label>
                                <select class="menu_id form-control" autocomplete="off">
                                    <option value="">{{ trans('w-cms-laravel::pages.choose_menu') }}</option>
                                    @if (isset($menus))
                                    @foreach ($menus as $menu)
                                    <option value="{{ $menu->ID }}" @if ($block->menu_id == $menu->ID) selected="selected" @endif>{{ $menu->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        @elseif ($block->type == 'view_file')
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
                                <input type="text" class="form-control view_file" placeholder="{{ trans('w-cms-laravel::pages.view_file') }}" value="{{ $block->view_file }}" autocomplete="off" />
                            </div>
                        @elseif ($block->type == 'article')
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_article') }}</label>
                                <select class="article_id form-control" autocomplete="off">
                                    <option value="">{{ trans('w-cms-laravel::pages.choose_article') }}</option>
                                    @if (isset($articles))
                                    @foreach ($articles as $article)
                                    <option value="{{ $article->ID }}" @if (isset($block->article_id) && $block->article_id == $article->ID) selected="selected" @endif>{{ $article->title }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        @elseif ($block->type == 'article_list')
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_article_list_category') }}</label>
                                <select class="article_list_category_id form-control" autocomplete="off">
                                    <option value="">{{ trans('w-cms-laravel::pages.choose_article_list_category') }}</option>
                                    @if (isset($article_categories))
                                        @foreach ($article_categories as $category)
                                        <option value="{{ $category->ID }}" @if (isset($block->article_list_category_id) && $block->article_list_category_id == $category->ID) selected="selected" @endif>{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_article_list_number') }}</label>
                                <input type="text" class="form-control article_list_number" placeholder="{{ trans('w-cms-laravel::pages.block_article_list_number') }}" value="{{ $block->article_list_number }}" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
                                <input type="radio" value="asc" name="article_list_order-{{ $block->ID }}" class="article_list_order_asc" @if ($block->article_list_order == 'asc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.ascending') }}
                                <input type="radio" value="desc" name="article_list_order-{{ $block->ID }}" class="article_list_order_desc" @if ($block->article_list_order == 'desc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.descending') }}
                            </div>
                        @elseif ($block->type == 'global')
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::blocks.global_block') }}</label>
                                <select class="article_id form-control" autocomplete="off">
                                    <option value="">{{ trans('w-cms-laravel::pages.choose_global_block') }}</option>
                                    @if (isset($global_blocks))
                                    @foreach ($global_blocks as $global_block)
                                    <option value="{{ $global_block->ID }}" @if (isset($block->block_reference_id) && $block->block_reference_id == $global_block->ID) selected="selected" @endif>{{ $global_block->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif

                        <!-- Save -->
                        <div class="submit_wrapper">
                            <input type="button" data-id="{{ $block->ID }}" class="page-content-save-block btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                            <input type="button" data-id="{{ $block->ID }}" class="page-content-close-block btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                        </div>
                        <!-- Save -->

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!-- Blocks content -->
</div>
<!-- CONTENT -->