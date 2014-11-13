@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.article_categories') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.article_categories') }}</li>
        </ol>

        <h1 class="article_category-header">{{ trans('w-cms-laravel::header.article_categories') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($article_categories)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('w-cms-laravel::article_categories.name') }}</th>
                    <th>{{ trans('w-cms-laravel::article_categories.description') }}</th>
                    <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($article_categories as $article_category)
                <tr>
                    <td>{{{ $article_category->ID or ''}}}</td>
                    <td>{{ $article_category->name }}</td>
                    <td>{{ $article_category->description }}</td>
                    <td>
                        <a class="btn btn-default" href="{{ route('back_article_categories_edit', array($article_category->ID)) }}" title="{{ $article_category->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                        <a class="btn btn-danger" href="{{ route('back_article_categories_delete', array($article_category->ID)) }}" title="{{ $article_category->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{ trans('w-cms-laravel::article_categories.no_article_category_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_article_categories_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
    </div>
</div>

@stop