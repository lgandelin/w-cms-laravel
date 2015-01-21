@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('page_name')
{{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('content')

<div class="container-fluid media-edit">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_medias_index') }}">{{ trans('w-cms-laravel::header.medias') }}</a></li>
            <li class="active">{{ $media->name }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.medias_edit') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($media)
        <form role="form" action="{{ route('back_medias_update') }}" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">{{ trans('w-cms-laravel::medias.name') }}</label>
                <input autocomplete="off" type="text" class="form-control media-name" id="name" name="name" placeholder="{{ trans('w-cms-laravel::medias.name') }}" value="{{ $media->name }}" />
            </div>

            <div class="form-group">
                <label for="">{{ trans('w-cms-laravel::medias.thumbnail') }}</label>
                <span class="media-thumbnail thumbnail">
                    <img src="{{ asset('img/uploads/' . $media->path) }}" />
                </span>
            </div>

            <div class="form-group">
                <label for="path">{{ trans('w-cms-laravel::medias.path') }}</label>
                <input autocomplete="off" type="text" class="form-control media-path" id="path" name="path" placeholder="{{ trans('w-cms-laravel::medias.path') }}" value="{{ $media->path }}" width="50%" />

                <span class="btn  btn-primary btn-file">
                    {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                </span>
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_medias_index') }}" name="{{ trans('w-cms-laravel::header.medias') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

            <input type="hidden" name="ID" value="{{ $media->ID }}" />
        </form>
        @else
        {{ trans('w-cms-laravel::medias.not_found') }}
        @endif

    </div>
</div>

@stop