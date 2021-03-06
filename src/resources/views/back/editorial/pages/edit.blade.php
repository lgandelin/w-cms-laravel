@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_edit') }} > {{{ $page->name or '' }}}
@stop

@section('javascripts')
    @parent
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

                    <input type="hidden" id="page_id" value="{{ $page->ID }}" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </div>

                <div style="display: none">
                    @foreach ($block_types as $blockType)
                        @if (isset($blockType->back_content))
                            <div id="block-template-{{ $blockType->code }}">
                                {!! $blockType->back_content !!}
                            </div>
                        @endif
                    @endforeach
                </div>

			@else
				{{ trans('w-cms-laravel::pages.not_found') }}
			@endif
			
		</div>
	</div>

@stop