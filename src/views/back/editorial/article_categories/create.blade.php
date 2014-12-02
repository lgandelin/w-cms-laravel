@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.article_categories_create') }} > {{ trans('w-cms-laravel::article_categories.new_article_category') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_article_categories_index') }}">{{ trans('w-cms-laravel::header.article_categories') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::article_categories.new_article_category') }}</li>
        </ol>

        <h1 class="article-header">{{ trans('w-cms-laravel::titles.article_categories_create') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <form role="form" action="{{ route('back_article_categories_store') }}" method="post">
            <div class="form-group">
                <label for="name">{{ trans('w-cms-laravel::article_categories.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::article_categories.name') }}" value="{{{ $article->name or '' }}}" />
            </div>

            <div class="form-group">
                <label for="description">{{ trans('w-cms-laravel::article_categories.description') }}</label>
                <textarea class="form-control" id="description" name="description" rows="5">{{{ $article->description or ''}}}</textarea>
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_article_categories_index') }}" title="{{ trans('w-cms-laravel::header.article_categories') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        </form>

    </div>
</div>

@stop