@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_create') }} > {{ trans('w-cms-laravel::pages.new_page') }}
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
				<li class="active">{{ trans('w-cms-laravel::pages.new_page') }}</li>
			</ol>

			<h1 class="page-header">{{ trans('w-cms-laravel::titles.pages_create') }}</h1>
			
			@if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

			<form role="form" action="{{ route('back_pages_store') }}" method="post">
				<div class="form-group">
				    <label for="name">{{ trans('w-cms-laravel::pages.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::pages.name') }}" value="{{{ $page->name or '' }}}" />
				</div>

				<div class="form-group">
				    <label for="identifier">{{ trans('w-cms-laravel::pages.identifier') }}</label>
				    <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::pages.identifier') }}" value="{{{ $page->identifier or ''}}}" />
				</div>

				<div class="form-group">
				    <label for="uri">{{ trans('w-cms-laravel::pages.uri') }}</label>
				    <input type="text" class="form-control" id="uri" name="uri" placeholder="{{ trans('w-cms-laravel::pages.uri') }}" value="{{{ $page->uri or '' }}}" />
				</div>

                <div class="form-group">
                    <label for="master_page_id">{{ trans('w-cms-laravel::pages.master_page') }}</label>
                    <select name="master_page_id" class="form-control" autocomplete="off">
                        <option value="">{{ trans('w-cms-laravel::pages.choose_master_page') }}</option>
                        @if (isset($master_pages))
                            @foreach ($master_pages as $master_page)
                                <option value="{{ $master_page->ID }}">{{ $master_page->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
				<input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
				<a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
			</form>
			
		</div>
	</div>

@stop