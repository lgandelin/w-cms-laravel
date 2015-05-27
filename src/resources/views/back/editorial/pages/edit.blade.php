@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_edit') }} > {{{ $page->name or '' }}}
@stop

@section('javascripts')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	{!! HTML::script('vendor/w-cms-laravel/back/js/page_content.js') !!}
	{!! HTML::script('vendor/w-cms-laravel/back/js/page_structure_areas.js') !!}
	{!! HTML::script('vendor/w-cms-laravel/back/js/page_structure_blocks.js') !!}
@stop

@section('content')

	<div class="container-fluid pages-interface">
		<div class="row main">
			
		    <ol class="breadcrumb">
				<li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
				<li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
				<li><a href="{{ route('back_pages_index') }}">{{ trans('w-cms-laravel::header.pages') }}</a></li>
				<li class="active">{{{ $page->name or '' }}}</li>
			</ol>

			<h1 class="page-header">{{ trans('w-cms-laravel::header.pages_edit') }}</h1>
			
			@if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
			@if ($page)

                <ul class="nav nav-tabs tab-navigation" role="tablist">
                    <li class="active"><a href="#content" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.content') }}</a></li>
                    <li><a href="#structure" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.structure') }}</a></li>
                    <li><a href="#versions" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.versions') }}</a></li>
                    <li><a href="#seo" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.seo') }}</a></li>
                </ul>

                <div class="tab-content">

                    @include('w-cms-laravel::back.editorial.pages.edit_content')

                    @include('w-cms-laravel::back.editorial.pages.edit_structure')

                    @include('w-cms-laravel::back.editorial.pages.edit_versions')

                    @include('w-cms-laravel::back.editorial.pages.edit_seo')

                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <div style="display:none;" id="html_template">
                        <textarea class="ckeditor" id="editor-html" name="html"></textarea>
                    </div>

                    <div style="display:none;" id="menu_template">
                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_menu') }}</label>
                            <select class="menu_id form-control" autocomplete="off">
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
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
                            <input type="text" class="form-control view_file" placeholder="{{ trans('w-cms-laravel::pages.block_view_file') }}" value="" autocomplete="off" />
                        </div>
                    </div>

                    <div style="display:none;" id="article_template">
                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_article') }}</label>
                            <select class="article_id form-control" autocomplete="off">
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
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_article_list_category') }}</label>
                            <select class="article_list_category_id form-control" autocomplete="off">
                                <option value="">{{ trans('w-cms-laravel::pages.choose_article_list_category') }}</option>
                                @if (isset($article_categories))
                                    @foreach ($article_categories as $category)
                                        <option value="{{ $category->ID }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_article_list_number') }}</label>
                            <input type="text" class="form-control article_list_number" placeholder="{{ trans('w-cms-laravel::pages.block_article_list_number') }}" value="" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <label>{{ trans('w-cms-laravel::pages.block_article_list_order') }}</label>
                            <input type="radio" value="asc" class="article_list_order_asc" name="article_list_order" autocomplete="off" /> {{ trans('w-cms-laravel::generic.ascending') }}
                            <input type="radio" value="desc" class="article_list_order_desc" name="article_list_order" checked autocomplete="off" /> {{ trans('w-cms-laravel::generic.descending') }}
                        </div>

                    </div>


                    <div style="display:none" id="global_blocks_template">
                        <div class="form-group">
                            <label for="block_reference_id">{{ trans('w-cms-laravel::blocks.global_block') }}</label>
                            <select class="block_reference_id form-control" autocomplete="off">
                                <option value="">{{ trans('w-cms-laravel::pages.choose_global_block') }}</option>
                                @if (isset($global_blocks))
                                    @foreach ($global_blocks as $global_block)
                                        <option value="{{ $global_block->ID }}">{{ $global_block->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div style="display:none;" id="media_template">
                        <div class="form-group">
                            <label>{{ trans('w-cms-laravel::blocks.media_block') }}</label>

                            <div class="thumbnail" style="width:200px; margin-bottom: 15px">
                                <img style="max-width: 100%; display:block" src="" />
                                <span class="media-name" style="margin-top: 5px; display: block;"></span>
                            </div>

                            <input type="button" class="btn btn-primary open-medias-modal" value="{{ trans('w-cms-laravel::generic.browse') }}" data-id="" />
                            <input class="media_id" type="hidden" value="" />
                        </div>

                        <div class="form-group">
                            <label for="media_format_id">{{ trans('w-cms-laravel::pages.block_media_format') }}</label>
                            <select class="media_format_id form-control" autocomplete="off">
                                <option value="">{{ trans('w-cms-laravel::pages.choose_media_format') }}</option>
                                @if (isset($media_formats))
                                    @foreach ($media_formats as $media_format)
                                        <option value="{{ $media_format->ID }}">{{ $media_format->name }} ({{ $media_format->width }} x {{ $media_format->height}})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('w-cms-laravel::pages.block_media_link') }}</label>
                            <input type="text" class="form-control media_link" placeholder="{{ trans('w-cms-laravel::pages.block_media_link') }}" autocomplete="off" />
                        </div>
                    </div>
                </div>

			@else
				{{ trans('w-cms-laravel::pages.not_found') }}
			@endif
			
		</div>
	</div>

@stop