@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.articles_create') }} > {{ trans('w-cms-laravel::articles.new_article') }}
@stop

@section('javascripts')
{!! HTML::script('vendor/w-cms-laravel/back/js/articles.js') !!}
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

        {!! Form::open(array('url' => route('back_articles_store'), 'method' => 'post')) !!}
            <div class="form-group">
                <label for="title">{{ trans('w-cms-laravel::articles.title') }}</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="{{ trans('w-cms-laravel::articles.title') }}" value="{{{ $article->title or '' }}}" />
            </div>

            <div class="row">
                <div class="form-group col-xs-6">
                    <label for="identifier">{{ trans('w-cms-laravel::articles.article_category') }}</label>
                    <select class="form-control" autocomplete="off" name="category_id">
                        <option value="">{{ trans('w-cms-laravel::articles.choose_article_category') }}</option>
                        @if (isset($article_categories))
                        @foreach ($article_categories as $category)
                        <option value="{{ $category->ID }}">{{ $category->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

            <div class="form-group">
                <label for="summary">{{ trans('w-cms-laravel::articles.summary') }}</label>
                <textarea class="form-control" id="summary" name="summary" rows="5">{{{ $article->summary or ''}}}</textarea>
            </div>

            <div class="form-group">
                <label for="text">{{ trans('w-cms-laravel::articles.text') }}</label>
                <textarea rows="10" class="form-control ckeditor" id="text" name="text">{{{ $article->text or ''}}}</textarea>
            </div>

            <div class="form-group">
                <label>{{ trans('w-cms-laravel::articles.media') }}</label>
                <select name="media_id" class="media_id form-control" autocomplete="off">
                    <option value="">{{ trans('w-cms-laravel::pages.choose_media') }}</option>
                    @if (isset($medias))
                        @foreach ($medias as $media)
                        <option value="{{ $media->ID }}" @if (isset($article->media_id) && $article->media_id == $media->ID) selected="selected" @endif>{{ $media->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="text">{{ trans('w-cms-laravel::articles.publication_date') }}</label>
                <input autocomplete="off" type="text" class="form-control" id="publication_date" name="publication_date" placeholder="{{ trans('w-cms-laravel::articles.publication_date') }}" value="{{ date('d/m/Y H:i') }}" />
            </div>

            @if ($user)
            <input type="hidden" name="author_id" value="{{ $user->id }}" />
            @endif

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_articles_index') }}" title="{{ trans('w-cms-laravel::header.articles') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        {!! Form::close() !!}

    </div>
</div>

@stop