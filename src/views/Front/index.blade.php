@extends('w-cms-laravel::front.master')

@section('page_title')
	@if ($current_page->meta_title)
		{{ $current_page->meta_title }}
	@else
		{{$current_page->name }}
	@endif
@stop

@section('meta_description')
	@if ($current_page->meta_description)
		<meta name="description" content="{{ $current_page->meta_description }}" />
	@endif
@stop

@section('meta_keywords')
	@if ($current_page->meta_keywords)
		<meta name="keywords" content="{{ $current_page->meta_keywords }}" />
	@endif
@stop

@section('content')
	@if ($pages)
		<nav>
			<ul>
				@foreach ($pages as $page)
					@if ($current_page->uri == $page->uri)
						<li class="selected">{{ $page->name }}</li>
					@else
						<li><a href="{{ route('front_page_index', array($page->uri)) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
					@endif
				@endforeach
			</ul>
		</nav>
	@endif

	<section class="content">
		{{ $current_page->text }}
	</section>
@stop