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
	<section class="content row">
        @if (isset($current_page->areas))
            @foreach ($current_page->areas as $area)

                @if ($area->display)
                    <div class="col-xs-{{ $area->width }} area {{ $area->class }}">
                        @if (isset($area->blocks))
                            @foreach ($area->blocks as $block)
                                @if ($block->display)
                                    <div class="col-xs-{{ $block->width }} block {{ $block->class }}">
                                        @if ($block->type == 'html')
                                            {{ $block->html }}
                                        @elseif ($block->type == 'menu' && isset($block->menu))
                                            <nav class="navbar navbar-default" role="navigation">
                                                <ul class="nav navbar-nav">
                                                    @foreach ($block->menu->items as $item)
                                                        @if (isset($item->page))
                                                            @if ($current_page->uri == $item->page->uri)
                                                                <li><a>{{ $item->label }}</a></li>
                                                            @else
                                                                <li><a href="{{ route('front_page_index', array($item->page->uri)) }}" title="{{ $item->page->name }}">{{ $item->label }}</a></li>
                                                            @endif
                                                        @else
                                                            <li><a>{{ $item->label }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </nav>
                                        @elseif ($block->type == 'view_file')
                                            @include($block->view_file)
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
            @endforeach
        @endif
	</section>
@stop