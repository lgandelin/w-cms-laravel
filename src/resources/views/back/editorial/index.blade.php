@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.editorial') }}
@stop

@section('content')

	<div class="container-fluid">
		<div class="row main">

			<ol class="breadcrumb">
				<li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
				<li class="active">{{ trans('w-cms-laravel::header.editorial') }}</li>
			</ol>

			<h1 class="page-header">{{ trans('w-cms-laravel::header.editorial') }}</h1>

			<ul class="shortcuts">
                <li>
                    <a href="{{ route('back_pages_index') }}">
                          <span class="icon glyphicon glyphicon-file"></span>
                          {{ trans('w-cms-laravel::header.pages') }}
                      </a>
                  </li>

                <li>
                    <a href="{{ route('back_articles_index') }}">
                        <span class="icon glyphicon glyphicon-font"></span>
                        {{ trans('w-cms-laravel::header.articles') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('back_menus_index') }}">
                        <span class="icon glyphicon glyphicon glyphicon-align-justify"></span>
                        {{ trans('w-cms-laravel::header.menus') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('back_medias_index') }}">
                        <span class="icon glyphicon glyphicon glyphicon-picture"></span>
                        {{ trans('w-cms-laravel::header.medias') }}
                    </a>
                </li>
            </ul>

		</div>
	</div>

@stop