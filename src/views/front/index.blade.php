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
                                                        @if ($item->display)

                                                            @if (isset($item->page))
                                                                <li class="{{ $item->class }} @if ($current_page->uri == $item->page->uri) current @endif"><a href="{{ route('front_page_index', array($item->page->uri)) }}" title="{{ $item->page->name }}">{{ $item->label }}</a></li>
                                                            @elseif ($item->external_url)
                                                                <li class="{{ $item->class }}"><a href="{{ $item->external_url }}" target="_blank">{{ $item->label }}</a></li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </nav>
                                        @elseif ($block->type == 'view_file' && $block->view_file != '')
                                            @include($block->view_file)
                                        @elseif ($block->type == 'article' && isset($block->article))
                                            <h2>{{ $block->article->title }}</h2>
                                            {{ $block->article->text }}
                                            {{--
                                            <p>Author : @if ($block->article->author){{ $block->article->author->first_name }} {{ $block->article->author->last_name }}@endif</p>
                                            @if ($block->article->publication_date) <p>Date de publication : {{ date('d/m/Y H\hi', strtotime($block->article->publication_date)) }}</p> @endif
                                            --}}
                                        @elseif ($block->type == 'article_list')
                                            <ul>
                                                @foreach ($block->articles as $article)
                                                    <li>
                                                        <h4>{{ $article->title }}</h4>
                                                        <p>{{ $article->summary }}</p>
                                                        @if (isset($article->page))<a href="{{ route('front_page_index', array($article->page->uri)) }}">En savoir plus</a>@endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @elseif ($block->type == 'media' && isset($block->media))
                                            <img src="{{ asset('img/uploads/' . $block->media->ID . '/' . $block->media->path) }}" alt="{{ $block->media->alt }}" @if ($block->media->title) title="{{ $block->media->title }}" @endif style="display: block; max-width: 100%; height: auto" />
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