@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.media_formats_edit') }} > {{ $media_format->name}}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_media_formats_index') }}">{{ trans('w-cms-laravel::header.media_formats') }}</a></li>
            <li class="active">{{ $media_format->name }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.media_formats_edit') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($media_format)
            {!! Form::open(array('url' => route('back_media_formats_update'), 'method' => 'post')) !!}

                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::media_formats.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::media_formats.name') }}" value="{{ $media_format->name }}" />
                </div>

                <div class="form-group">
                    <label for="width">{{ trans('w-cms-laravel::media_formats.width') }}</label>
                    <input type="width" class="form-control" id="width" name="width" placeholder="{{ trans('w-cms-laravel::media_formats.width') }}" value="{{ $media_format->width }}" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label for="height">{{ trans('w-cms-laravel::media_formats.height') }}</label>
                    <input type="text" class="form-control" id="height" name="height" placeholder="{{ trans('w-cms-laravel::media_formats.height') }}" value="{{ $media_format->height }}" />
                </div>

                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_media_formats_index') }}" title="{{ trans('w-cms-laravel::header.media_formats') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                <input type="hidden" name="ID" value="{{ $media_format->ID }}" />

            {!! Form::close() !!}
        @else
        {{ trans('w-cms-laravel::media_formats.not_found') }}
        @endif

    </div>
</div>

@stop