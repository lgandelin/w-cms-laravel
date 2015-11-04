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

        <h1 class="page-header">{{ trans('w-cms-laravel::header.medias') }}</h1>

        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif

        {{--@if ($medias)
            <ul class="medias-list">
                @foreach ($medias as $media)
                    <li>
                        <a href="{{ route('back_medias_edit', $media->ID) }}" class="thumbnail">
                            <img src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}" width="250" height="250" />
                            <span class="media-name">{{ $media->name }}</span>
                        </a>
                        <a href="{{ route('back_medias_delete', $media->ID) }}" class="glyphicon glyphicon-remove media-delete"></a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ trans('w-cms-laravel::medias.no_media_created_yet') }}</p>
        @endif--}}

        <div id="medias-library"></div>

        <a class="btn btn-primary" href="{{ route('back_medias_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>

        <a class="btn btn-success" href="{{ route('back_media_formats_index') }}" title="{{ trans('w-cms-laravel::medias.media_formats') }}">{{ trans('w-cms-laravel::medias.media_formats') }}</a>
    </div>
</div>

@stop

@section('javascripts')
    {!! HTML::script('vendor/w-cms-laravel/back/js/medias.js') !!}

    <script>
    $(document).ready(function() {
        load_medias_library();
    });
    </script>
@stop