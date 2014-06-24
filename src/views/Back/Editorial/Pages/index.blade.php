@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages') }}
@stop

@section('content')

	<div class="container-fluid">
		<div class="row main">
			
			<ol class="breadcrumb">
				<li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
				<li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
				<li class="active">{{ trans('w-cms-laravel::header.pages') }}</li>
			</ol>

			<h1 class="page-header">{{ trans('w-cms-laravel::header.pages') }}</h1>
			
			@if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
			@if ($pages)
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ trans('w-cms-laravel::pages.name') }}</th>
							<th>{{ trans('w-cms-laravel::pages.identifier') }}</th>
							<th>{{ trans('w-cms-laravel::pages.uri') }}</th>
							<th>{{ trans('w-cms-laravel::generic.action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pages as $page)
						<tr>
							<td>{{{ $page->id or ''}}}</td>
							<td>{{ $page->name }}</td>
							<td>{{ $page->identifier }}</td>
							<td>{{ $page->uri }}</td>
							<td>
								<a class="btn btn-default" href="{{ route('back_pages_edit', array($page->identifier)) }}" title="{{ $page->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
								<a class="btn btn-default" href="{{ route('back_pages_duplicate', array($page->identifier)) }}" title="{{ $page->name }}">{{ trans('w-cms-laravel::generic.duplicate') }}</a>
								<a class="btn btn-danger" href="{{ route('back_pages_delete', array($page->identifier)) }}" title="{{ $page->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			@else
				{{ trans('w-cms-laravel::pages.no_page_created_yet') }}
			@endif
			
			<a class="btn btn-primary" href="{{ route('back_pages_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
		</div>
	</div>

@stop