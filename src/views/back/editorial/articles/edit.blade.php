@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.articles_edit') }} > {{ $article->title }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_articles_index') }}">{{ trans('w-cms-laravel::header.articles') }}</a></li>
            <li class="active">{{ $article->title }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.articles_edit') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($article)
        <form role="form" action="{{ route('back_articles_update') }}" method="post">
            <div class="form-group">
                <label for="title">{{ trans('w-cms-laravel::articles.title') }}</label>
                <input autocomplete="off" type="text" class="form-control" id="title" name="title" placeholder="{{ trans('w-cms-laravel::articles.title') }}" value="{{ $article->title }}" />
            </div>

            <div class="form-group">
                <label for="summary">{{ trans('w-cms-laravel::articles.summary') }}</label>
                <textarea class="form-control ckeditor" id="summary" name="summary">{{{ $article->summary or ''}}}</textarea>
            </div>

            <div class="form-group">
                <label for="text">{{ trans('w-cms-laravel::articles.text') }}</label>
                <textarea class="form-control ckeditor" id="text" name="text">{{{ $article->text or ''}}}</textarea>
            </div>

            <div class="form-group">
                <label for="text">{{ trans('w-cms-laravel::articles.publication_date') }}</label>
                <input autocomplete="off" type="text" class="form-control" id="publication_date" name="publication_date" placeholder="{{ trans('w-cms-laravel::articles.publication_date') }}" value="{{ date('d/m/Y H:i', strtotime($article->publication_date)) }}" />
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_articles_index') }}" title="{{ trans('w-cms-laravel::header.articles') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

            <input type="hidden" name="ID" value="{{ $article->ID }}" />
        </form>
        @else
        {{ trans('w-cms-laravel::articles.not_found') }}
        @endif

    </div>
</div>

@stop