@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::header.medias_create') }}
@stop

@section('page_name')
{{ trans('w-cms-laravel::header.medias_create') }}
@stop

@section('content')

<div class="container-fluid media-edit">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_medias_index') }}">{{ trans('w-cms-laravel::header.medias') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.medias_create') }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.medias_create') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <form role="form" action="{{ route('back_medias_store') }}" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">{{ trans('w-cms-laravel::medias.name') }}</label>
                <input autocomplete="off" type="text" class="form-control media-name" id="name" name="name" placeholder="{{ trans('w-cms-laravel::medias.name') }}" value="" />
            </div>

            <div class="form-group">
                <label for="path">{{ trans('w-cms-laravel::medias.path') }}</label>
                <input autocomplete="off" type="text" class="form-control media-path" id="path" name="path" placeholder="{{ trans('w-cms-laravel::medias.path') }}" value="" width="50%" />

                <span class="btn  btn-primary btn-file">
                    {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                </span>
            </div>

            <div class="form-group">
                <label for="alt">{{ trans('w-cms-laravel::medias.alt') }}</label>
                <input autocomplete="off" type="text" class="form-control media-alt" id="alt" name="alt" placeholder="{{ trans('w-cms-laravel::medias.alt') }}" value="{{ $media->alt }}" />
            </div>

            <div class="form-group">
                <label for="title">{{ trans('w-cms-laravel::medias.title') }}</label>
                <input autocomplete="off" type="text" class="form-control media-title" id="title" name="title" placeholder="{{ trans('w-cms-laravel::medias.title') }}" value="{{ $media->title }}" />
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_medias_index') }}" name="{{ trans('w-cms-laravel::header.medias') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        </form>

    </div>
</div>

@stop