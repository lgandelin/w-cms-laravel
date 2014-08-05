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
			<form role="form" action="{{ route('back_pages_update') }}" method="post">
                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::pages.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::pages.name') }}" value="{{ $page->name }}" />
                </div>

				<div class="form-group">
               		<label for="uri">{{ trans('w-cms-laravel::pages.uri') }}</label>
                    <input type="text" class="form-control" id="uri" name="uri" placeholder="{{ trans('w-cms-laravel::pages.uri') }}" value="{{ $page->uri }}" />
                </div>

                <div class="form-group">
                    <label for="identifier">{{ trans('w-cms-laravel::pages.identifier') }}</label>
                    <input type="text" class="form-control" id="identifier" name="uri" placeholder="{{ trans('w-cms-laravel::pages.identifier') }}" value="{{ $page->identifier }}" />
                </div>

				<div class="form-group">
                    <label for="text">{{ trans('w-cms-laravel::pages.text') }}</label>
                    <textarea class="form-control" id="text" name="text" rows="30">{{ $page->text }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="meta_title">{{ trans('w-cms-laravel::pages.meta_title') }}</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="{{ trans('w-cms-laravel::pages.meta_title') }}" value="{{ $page->meta_title }}" />
                </div>

				<div class="form-group">
                    <label for="meta_description">{{ trans('w-cms-laravel::pages.meta_description') }}</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="5">{{ $page->meta_description }}</textarea>
                </div>

				<div class="form-group">
                    <label for="meta_keywords">{{ trans('w-cms-laravel::pages.meta_keywords') }}</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="{{ trans('w-cms-laravel::pages.meta_keywords') }}" value="{{ $page->meta_keywords }}" />
                </div>
                
                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                <input type="hidden" name="ID" value="{{ $page->ID }}" />
            </form>
			@else
				{{ trans('w-cms-laravel::pages.not_found') }}
			@endif
			
		</div>
	</div>

@stop