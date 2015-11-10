@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('page_name')
    {{ trans('w-cms-laravel::header.medias_edit') }} > {{ $media->name }}
@stop

@section('stylesheets')
    {!! HTML::style('vendor/w-cms-laravel/back/vendor/cropper-master/dist/cropper.min.css') !!}
@stop

@section('javascripts')
    @parent
    {!! HTML::script('vendor/w-cms-laravel/back/vendor/cropper-master/dist/cropper.js') !!}
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
            {!! Form::open(array('url' => route('back_medias_update'), 'method' => 'post', 'class' => 'row', 'enctype' => 'multipart/form-data')) !!}

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

                    <div class="form-group">
                        <label for="">{{ trans('w-cms-laravel::medias.file_name') }}</label>
                        <input autocomplete="off" type="text" class="form-control" id="file_name" name="file_name" placeholder="{{ trans('w-cms-laravel::medias.file_name') }}" value="{{ $media->fileName }}" />
                    </div>

                    <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                    <a class="btn btn-default" href="{{ route('back_medias_index') }}" name="{{ trans('w-cms-laravel::header.medias') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                    <input type="hidden" name="ID" value="{{ $media->ID }}" />


                    <!-- FORMATS -->
                    <div>
                        <h2>Formats</h2>
                        @foreach ($media_formats as $media_format)
                        <div class="form-group media-format" data-media-format-id="{{ $media_format->ID }}" data-width="{{ $media_format->width }}" data-height="{{ $media_format->height }}" data-preserve-ratio="{{ $media_format->preserveRatio }}">
                            <label for="">{{ $media_format->name }} ({{ $media_format->width }} x {{ $media_format->height }})</label>
                            <div class="media-format-image">
                                <img src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media_format->width . '_' . $media_format->height . '_' . $media->fileName) }}?date={{ time() }}" />
                            </div>

                            <div style="margin-top: 20px; margin-bottom: 50px">
                                <input type="button" class="btn btn-primary btn-activate-crop" value="{{ trans('w-cms-laravel::medias.crop') }}" />
                            </div>

                        </div>
                        @endforeach
                    </div>
                    <!-- FORMATS -->

                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">{{ trans('w-cms-laravel::medias.thumbnail') }}</label>
                        <div class="media-thumbnail">
                            <img src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}" />
                        </div>
                        <span class="btn btn-primary btn-file">
                            {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                        </span>
                    </div>

                </div>

            {!! Form::close() !!}


            <!-- CROP MEDIA MODAL-->
            <div class="modal fade" id="crop-medias-modal" tabindex="-1" role="dialog" aria-labelledby="area-infos" aria-hidden="true">
                <div class="modal-dialog modal-full">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="area-infos">Redimensionner média</h4>
                        </div>

                        <div class="modal-body">
                            <div class="cropper-container">
                                <img class="media-image-to-crop" src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}?date={{ time() }}" />
                            </div>
                            <span>Largeur :</span> <input id="dataWidth" autocomplete="off" style="border:none; width: 50px" /> px
                            <span>Hauteur :</span> <input id="dataHeight" autocomplete="off" style="border:none; width: 50px" /> px
                        </div>

                        <div class="modal-footer">
                            <input type="button" class="btn btn-success btn-valid-crop" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                            <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- CROP MEDIA MODAL -->

        @else
        {{ trans('w-cms-laravel::medias.not_found') }}
        @endif

    </div>
</div>

@stop