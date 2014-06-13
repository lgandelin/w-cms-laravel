@extends('w-cms-laravel::front.master')

@section('page_title')
	@if ($current_page->getMetaTitle())
		{{ $current_page->getMetaTitle() }}
	@else
		{{$current_page->getName() }}
	@endif
@stop

@section('meta_description')
	@if ($current_page->getMetaDescription())
		<meta name="description" content="{{ $current_page->getMetaDescription() }}" />
	@endif
@stop

@section('meta_keywords')
	@if ($current_page->getMetaKeywords())
		<meta name="keywords" content="{{ $current_page->getMetaKeywords() }}" />
	@endif
@stop

@section('content')
	@if ($pages)
		<nav>
			<ul>
				@foreach ($pages as $page)
					@if ($current_page->getUri() == $page->uri)
						<li class="selected">{{ $page->name }}</li>
					@else
						<li><a href="{{ route('front_page_index', array($page->uri)) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
					@endif
				@endforeach
			</ul>
		</nav>
	@endif

	<section class="content">
		{{ $current_page->getText() }}
	</section>
@stop