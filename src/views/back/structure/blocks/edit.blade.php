@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.blocks_edit') }} > {{ $block->name }}
@stop

@section('javascripts')
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
{{ HTML::script('packages/webaccess/w-cms-laravel/back/js/blocks.js') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_structure') }}">{{ trans('w-cms-laravel::header.structure') }}</a></li>
            <li><a href="{{ route('back_global_blocks_index') }}">{{ trans('w-cms-laravel::header.blocks') }}</a></li>
            <li class="active">{{ $block->name }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.blocks_edit') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($block)
        <form role="form" action="{{ route('back_global_blocks_update') }}" method="post">

            <!-- Name -->
            <div class="form-group">
                <label>{{ trans('w-cms-laravel::pages.block_name') }}</label>
                <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.block_name') }}" autocomplete="off" value="{{ $block->name }}" name="name" />
            </div>
            <!-- Name -->

            <!-- Type -->
            <div class="form-group">
                <label>{{ trans('w-cms-laravel::pages.block_type') }}</label>
                <select class="form-control" autocomplete="off" name="type">
                    <option value="">{{ trans('w-cms-laravel::blocks.choose_block_type') }}</option>
                    <option value="html" @if ($block->type == 'html') selected @endif>{{ trans('w-cms-laravel::blocks.html_block') }}</option>
                    <option value="menu" @if ($block->type == 'menu') selected @endif>{{ trans('w-cms-laravel::blocks.navigation_block') }}</option>
                    <option value="view_file" @if ($block->type == 'view_file') selected @endif>{{ trans('w-cms-laravel::blocks.view_block') }}</option>
                    <option value="article" @if ($block->type == 'article') selected @endif>{{ trans('w-cms-laravel::blocks.article_block') }}</option>
                    <option value="article_list" @if ($block->type == 'article_list') selected @endif>{{ trans('w-cms-laravel::blocks.article_list_block') }}</option>
                    <option value="media" @if ($block->type == 'media') selected @endif>{{ trans('w-cms-laravel::blocks.media_block') }}</option>
                </select>
            </div>
            <!-- Type -->

            <!-- Class -->
            <div class="form-group">
                <label>{{ trans('w-cms-laravel::pages.block_class') }}</label>
                <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.block_class') }}" autocomplete="off" value="{{ $block->class }}" name="class" />
            </div>
            <!-- Class-->

            <div class="content">
                @if ($block->type == 'html')
                    <textarea class="ckeditor" id="editor{{ $block->ID }}" name="html">{{ $block->html }}</textarea>
                @elseif ($block->type == 'menu')
                    <div class="form-group">
                        <label>{{ trans('w-cms-laravel::pages.block_menu') }}</label>
                        <select class="form-control" autocomplete="off" name="menu_id">
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
                        <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.view_file') }}" value="{{ $block->view_file }}" autocomplete="off" name="view_file" />
                    </div>
                @elseif ($block->type == 'article')
                    <div class="form-group">
                        <label>{{ trans('w-cms-laravel::pages.block_article') }}</label>
                        <select class="form-control" autocomplete="off" name="article_id">
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
                        <select class="form-control" autocomplete="off" name="article_list_category_id">
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
                        <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.block_article_list_number') }}" value="{{ $block->article_list_number }}" autocomplete="off" name="article_list_number"/>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
                        <input type="radio" value="asc" name="article_list_order" @if ($block->article_list_order == 'asc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.ascending') }}
                        <input type="radio" value="desc" name="article_list_order"  @if ($block->article_list_order == 'desc')checked @endif autocomplete="off" /> {{ trans('w-cms-laravel::generic.descending') }}
                    </div>
                @elseif ($block->type == 'media')
                    <div class="form-group">
                        <label>{{ trans('w-cms-laravel::pages.block_media') }}</label>
                        <select class="form-control" autocomplete="off" name="media_id">
                            <option value="">{{ trans('w-cms-laravel::pages.choose_media') }}</option>
                            @if (isset($medias))
                            @foreach ($medias as $media)
                            <option value="{{ $media->ID }}" @if (isset($block->media_id) && $block->media_id == $media->ID) selected="selected" @endif>{{ $media->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                @endif
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_global_blocks_index') }}" title="{{ trans('w-cms-laravel::header.blocks') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

            <input type="hidden" name="ID" value="{{ $block->ID }}" />
        </form>
        @else
        {{ trans('w-cms-laravel::blocks.not_found') }}
        @endif

    </div>

    <div style="display:none;" id="select_menu_template">
        <div class="form-group">
            <label for="menu_id">{{ trans('w-cms-laravel::pages.block_menu') }}</label>
            <select class="form-control" autocomplete="off" name="menu_id">
                <option value="">{{ trans('w-cms-laravel::pages.choose_menu') }}</option>
                @if (isset($menus))
                @foreach ($menus as $menu)
                <option value="{{ $menu->ID }}">{{ $menu->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>

    <div style="display:none" id="view_file_template">
        <div class="form-group">
            <label for="view_file">{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
            <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.block_view_file') }}" value="" autocomplete="off" name="view_file" />
        </div>
    </div>

    <div style="display:none;" id="select_article_template">
        <div class="form-group">
            <label for="article_id">{{ trans('w-cms-laravel::pages.block_article') }}</label>
            <select class="form-control" autocomplete="off" name="article_id">
                <option value="">{{ trans('w-cms-laravel::pages.choose_article') }}</option>
                @if (isset($articles))
                @foreach ($articles as $article)
                <option value="{{ $article->ID }}">{{ $article->title }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>

    <div style="display:none" id="article_category_template">
        <div class="form-group">
            <label for="article_list_category_id">{{ trans('w-cms-laravel::pages.block_article_list_category') }}</label>
            <select class="form-control" autocomplete="off" name="article_list_category_id">
                <option value="">{{ trans('w-cms-laravel::pages.choose_article') }}</option>
                @if (isset($article_categories))
                @foreach ($article_categories as $category)
                <option value="{{ $category->ID }}">{{ $category->name }}</option>
                @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="article_list_number">{{ trans('w-cms-laravel::pages.block_article_list_number') }}</label>
            <input type="text" class="form-control" placeholder="{{ trans('w-cms-laravel::pages.block_article_list_number') }}" value="" autocomplete="off" name="article_list_number" />
        </div>

        <div class="form-group">
            <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
            <input type="radio" value="asc" class="article_list_order" autocomplete="off" name="article_list_order" /> {{ trans('w-cms-laravel::generic.ascending') }}
            <input type="radio" value="desc" class="article_list_order" checked autocomplete="off" name="article_list_order" /> {{ trans('w-cms-laravel::generic.descending') }}
        </div>

    </div>

    <div style="display:none;" id="select_media_template">
        <div class="form-group">
            <label for="media_id">{{ trans('w-cms-laravel::pages.block_media') }}</label>
            <select class="form-control" autocomplete="off" name="media_id">
                <option value="">{{ trans('w-cms-laravel::pages.choose_media') }}</option>
                @if (isset($medias))
                @foreach ($medias as $media)
                <option value="{{ $media->ID }}">{{ $media->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

@stop