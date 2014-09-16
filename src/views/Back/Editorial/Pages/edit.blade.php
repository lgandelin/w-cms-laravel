@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_edit') }} > {{{ $page->name or '' }}}
@stop

@section('javascripts')
	{{ HTML::script('packages/webaccess/w-cms-laravel/back/js/pages.js') }}
@stop

@section('content')

	<div class="container-fluid">
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

                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#content" role="tab" data-toggle="tab">Content</a></li>
                    <li><a href="#structure" role="tab" data-toggle="tab">Structure</a></li>
                    <li><a href="#versions" role="tab" data-toggle="tab">Versions</a></li>
                    <li><a href="#seo" role="tab" data-toggle="tab">SEO</a></li>
                </ul>

                <div class="tab-content">

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
                                <div class="area" style="background: #ddd; padding: 10px; border: 1px solid #ccc; margin-bottom: 20px">
                                    <span class="title" style="cursor: pointer; font-weight: bold; display: block; margin-bottom: 10px">[AREA] {{ $area->name }}</span>

                                    <div class="content" style="display: none">
                                        @foreach ($area->blocks as $block)
                                        <div class="block" data-type="html" data-id="{{ $block->ID }}" style="background: #eee; padding: 10px; border: 1px solid #ddd; margin-bottom: 20px">
                                            <span class="title" style="cursor: pointer; font-weight: bold; display: block; margin-bottom: 10px">[BLOCK] {{ $block->name }} <span class="type" style="font-weight: normal; text-transform: uppercase">({{ $block->type }})</span></span>

                                            <div class="content" style="display: none">
                                                @if ($block->type == 'html')
                                                <textarea class="ckeditor" id="editor{{ $block->ID }}" name="editor{{ $block->ID }}">{{ $block->html }}</textarea>
                                                @endif

                                                <input type="button" data-id="{{ $block->ID }}" class="page-content-save-block btn btn-success" style="margin-top: 20px" value="{{ trans('w-cms-laravel::generic.submit') }}" />
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



                    <!-- STRUCTURE -->
                    <div class="tab-pane" id="structure">
                        TODO
                    </div>
                    <!-- STRUCTURE -->



                    <!-- VERSIONS -->
                    <div class="tab-pane" id="versions">
                        TODO
                    </div>
                    <!-- VERSIONS -->



                    <!-- SEO -->
                    <div class="tab-pane" id="seo">

                        <!-- Uri -->
                        <div class="form-group">
                            <label for="uri">{{ trans('w-cms-laravel::pages.uri') }}</label>
                            <input type="text" class="form-control" id="uri" name="uri" placeholder="{{ trans('w-cms-laravel::pages.uri') }}" value="{{ $page->uri }}" autocomplete="off" />
                        </div>
                        <!-- Uri -->

                        <!-- Meta title -->
                        <div class="form-group">
                            <label for="meta_title">{{ trans('w-cms-laravel::pages.meta_title') }}</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="{{ trans('w-cms-laravel::pages.meta_title') }}" value="{{ $page->meta_title }}" autocomplete="off" />
                        </div>
                        <!-- Meta title -->

                        <!-- Meta description -->
                        <div class="form-group">
                            <label for="meta_description">{{ trans('w-cms-laravel::pages.meta_description') }}</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="5" autocomplete="off">{{ $page->meta_description }}</textarea>
                        </div>
                        <!-- Meta description -->

                        <!-- Meta keywords -->
                        <div class="form-group">
                            <label for="meta_keywords">{{ trans('w-cms-laravel::pages.meta_keywords') }}</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="{{ trans('w-cms-laravel::pages.meta_keywords') }}" value="{{ $page->meta_keywords }}" autocomplete="off" />
                        </div>
                        <!-- Meta keywords -->

                        <!-- Save -->
                        <div class="form-group">
                            <input type="button" data-id="{{ $page->ID }}" class="page-content-save-seo btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                            <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
                        </div>
                        <!-- Save -->
                    </div>
                    <!-- SEO -->

                </div>


			@else
				{{ trans('w-cms-laravel::pages.not_found') }}
			@endif
			
		</div>
	</div>

@stop