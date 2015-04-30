@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.medias') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.medias') }}</li>
        </ol>

        <h1 class="media-header">{{ trans('w-cms-laravel::header.medias') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($medias)
            <ul class="medias-list">
                @foreach ($medias as $media)
                    <li>
                        <a href="{{ route('back_medias_edit', $media->ID) }}" class="thumbnail">
                            <img src="{{ asset(env('W_CMS_UPLOADS_FOLDER', 'uploads/') . $media->ID . '/' . $media->file_name) }}" width="250" height="250" />
                            <span class="media-name">{{ $media->name }}</span>
                        </a>
                        <a href="{{ route('back_medias_delete', $media->ID) }}" class="glyphicon glyphicon-remove media-delete"></a>
                    </li>
                @endforeach
            </ul>
        @else
        {{ trans('w-cms-laravel::medias.no_media_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_medias_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>

        <a class="btn btn-success" href="{{ route('back_media_formats_index') }}" title="{{ trans('w-cms-laravel::medias.media_formats') }}">{{ trans('w-cms-laravel::medias.media_formats') }}</a>
    </div>
</div>

@stop