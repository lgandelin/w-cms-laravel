@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.articles') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.articles') }}</li>
        </ol>

        <h1 class="article-header">{{ trans('w-cms-laravel::header.articles') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($articles)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('w-cms-laravel::articles.title') }}</th>
                    <th>{{ trans('w-cms-laravel::articles.author') }}</th>
                    <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td>{{{ $article->ID or ''}}}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->author_id }}</td>
                    <td>
                        <a class="btn btn-default" href="{{ route('back_articles_edit', array($article->ID)) }}" title="{{ $article->title }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                        <a class="btn btn-danger" href="{{ route('back_articles_delete', array($article->ID)) }}" title="{{ $article->title }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{ trans('w-cms-laravel::articles.no_article_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_articles_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>

        <a class="btn btn-success" href="{{ route('back_article_categories_index') }}" title="{{ trans('w-cms-laravel::article_categories.article_categories') }}">{{ trans('w-cms-laravel::article_categories.article_categories') }}</a>
    </div>
</div>

@stop