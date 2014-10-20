@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.articles_create') }} > {{ trans('w-cms-laravel::articles.new_article') }}
@stop

@section('javascripts')
{{ HTML::script('packages/webaccess/w-cms-laravel/back/js/articles.js') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_articles_index') }}">{{ trans('w-cms-laravel::header.articles') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::articles.new_article') }}</li>
        </ol>

        <h1 class="article-header">{{ trans('w-cms-laravel::titles.articles_create') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <form role="form" action="{{ route('back_articles_store') }}" method="post">
            <div class="form-group">
                <label for="title">{{ trans('w-cms-laravel::articles.title') }}</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="{{ trans('w-cms-laravel::articles.title') }}" value="{{{ $article->title or '' }}}" />
            </div>

            <div class="form-group">
                <label for="summary">{{ trans('w-cms-laravel::articles.summary') }}</label>
                <textarea class="form-control ckeditor" id="summary" name="summary">{{{ $article->summary or ''}}}</textarea>
            </div>

            <div class="form-group">
                <label for="text">{{ trans('w-cms-laravel::articles.text') }}</label>
                <textarea rows="10" class="form-control ckeditor" id="text" name="text">{{{ $article->text or ''}}}</textarea>
            </div>

            <input type="hidden" name="author_id" value="1" />

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_articles_index') }}" title="{{ trans('w-cms-laravel::header.articles') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        </form>

    </div>
</div>

@stop