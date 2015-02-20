@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.article_categories_edit') }} > {{ $article_category->name }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_article_categories_index') }}">{{ trans('w-cms-laravel::header.article_categories') }}</a></li>
            <li class="active">{{ $article_category->name }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.article_categories_edit') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($article_category)
            {!! Form::open(array('url' => route('back_article_categories_update'), 'method' => 'post')) !!}
                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::article_categories.name') }}</label>
                    <input autocomplete="off" type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::article_categories.name') }}" value="{{ $article_category->name }}" />
                </div>

                <div class="form-group">
                    <label for="description">{{ trans('w-cms-laravel::article_categories.description') }}</label>
                    <textarea class="form-control" id="description" name="description" rows="5">{{{ $article_category->description or ''}}}</textarea>
                </div>

                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_article_categories_index') }}" title="{{ trans('w-cms-laravel::header.article_categories') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                <input type="hidden" name="ID" value="{{ $article_category->ID }}" />
            {!! Form::close() !!}
        @else
            {{ trans('w-cms-laravel::article_categories.not_found') }}
        @endif

    </div>
</div>

@stop