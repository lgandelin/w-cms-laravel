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

        <div class="medias-list" id="medias-library">
            <div class="update-in-progress" style="display: none"></div>
            <ol class="breadcrumb">
                <li class="active">{{ trans('w-cms-laravel::medias.breadcrumb_root') }}</li>
            </ol>
            <ul class="medias"></ul>
            <input type="hidden" id="current-media-folder-id" value="0" />
            <input type="hidden" id="parent-media-folder-id" value="0" />
            <div style="clear:both; margin-bottom: 30px">
                <a href="" class="btn-back btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span></a>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('back_medias_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
                <a class="btn btn-primary" href="{{ route('back_media_formats_index') }}" title="{{ trans('w-cms-laravel::medias.media_formats') }}">{{ trans('w-cms-laravel::medias.media_formats') }}</a>
            </div>
        </div>

        <div class="panel-create-folder panel panel-default">
            <div class="panel-body">
                    <h3 style="margin-top:0">Create a folder</h3>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="new-folder-name" autocomplete="off" placeholder="Name" style="width:300px" />
                    </div>
                    <a class="btn btn-success btn-create-folder" href="" title="{{ trans('w-cms-laravel::generic.create') }} folder">{{ trans('w-cms-laravel::generic.create') }} folder</a>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</div>

<script id="media-template" type="text/x-handlebars-template">
    <li>
        <a href="{{ route('back_medias_edit') }}/@{{ ID }}" class="thumbnail">
            <img src="{{ asset(Shortcut::get_uploads_folder()) }}/@{{ ID }}/@{{ fileName }}" width="250" height="250" />
            <span class="media-name">@{{ name }}</span>
        </a>
        <a href="{{ route('back_medias_delete') }}/@{{ ID }}" class="glyphicon glyphicon-remove media-delete"></a>
    </li>
</script>

<script id="media-folder-template" type="text/x-handlebars-template">
    <li class="media-folder" data-media-folder-id="@{{ ID }}" data-parent-media-folder-id="@{{ parentID }}">
        <a href="#" class="thumbnail">
            <div>
                <span class="folder">
                    <span class="glyphicon glyphicon-folder-open folder-icon"></span>
                </span>
                <span class="media-name" style="">@{{ name }}</span>
            </div>
        </a>
        <a href="#" class="glyphicon glyphicon-remove media-delete btn-delete-folder"></a>
    </li>
</script>

@stop

@section('javascripts')
    {!! HTML::script('vendor/w-cms-laravel/back/js/medias.js') !!}

    <script>
        $(document).ready(function() {
            load_medias_library(0);
        });
    </script>
@stop