@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('page_name')
{{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('stylesheets')
{{ HTML::style('packages/webaccess/w-cms-laravel/back/vendor/cropper-master/dist/cropper.min.css') }}
@stop

@section('javascripts')
{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/cropper-master/dist/cropper.js') }}
{{ HTML::script('packages/webaccess/w-cms-laravel/back/js/medias.js') }}
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
        <form role="form" action="{{ route('back_medias_update') }}" method="post" enctype="multipart/form-data" class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::medias.name') }}</label>
                    <input autocomplete="off" type="text" class="form-control media-name" id="name" name="name" placeholder="{{ trans('w-cms-laravel::medias.name') }}" value="{{ $media->name }}" />
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

                <input type="hidden" name="ID" value="{{ $media->ID }}" />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{ trans('w-cms-laravel::medias.thumbnail') }}</label>
                    <div class="media-thumbnail">
                        <img src="{{ asset('img/uploads/' . $media->ID . '/' . $media->file_name) }}" />
                    </div>
                    <span class="btn  btn-primary btn-file">
                        {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                    </span>
                </div>

                <div class="form-group">
                    <label for="">{{ trans('w-cms-laravel::medias.file_name') }}</label>
                    <input autocomplete="off" type="text" class="form-control" id="file_name" name="file_name" placeholder="{{ trans('w-cms-laravel::medias.file_name') }}" value="{{ $media->file_name }}" />
                </div>

                {{--
                <span class="btn  btn-primary btn-file">
                    {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                </span>
                <input type="button" class="btn btn-primary" value="{{ trans('w-cms-laravel::medias.crop') }}" id="btn-activate-crop" />
                <input type="button" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" id="btn-valid-crop" />

                <label for="dataWidth">Width :</label> <input id="dataWidth" autocomplete="off" style="border:none" />
                <label for="dataHeight">Height :</label> <input id="dataHeight" autocomplete="off" style="border:none" />
                --}}

            </div>
        </form>

        @else
        {{ trans('w-cms-laravel::medias.not_found') }}
        @endif

    </div>
</div>

@stop