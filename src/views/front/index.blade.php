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
	@if (isset($menu) && $menu->items)
        <nav class="navbar navbar-default" role="navigation">
            <ul class="nav navbar-nav">
				@foreach ($menu->items as $item)
	                @if ($item->page)
	                    @if ($current_page->uri == $item->page->uri)
                            <li><a>{{ $item->label }}</a>
	                    @else
	                        <li><a href="{{ route('front_page_index', array($item->page->uri)) }}" title="{{ $item->page->name }}">{{ $item->label }}</a></li>
	                    @endif
                     @endif
				@endforeach
			</ul>
		</nav>
	@endif

	<section class="content row">
        @if (isset($current_page->areas))
            @foreach ($current_page->areas as $area)
            <div class=" col-xs-{{ $area->width }}">
                <div class="area {{ $area->class }}">
                    @foreach ($area->blocks as $block)
                    <div class="col-xs-{{ $block->width }}">
                        <div class="block {{ $block->class }}">
                            @if ($block->type == 'html')
                                {{ $block->html }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
	</section>
@stop