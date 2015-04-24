@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::header.media_formats_create') }}
@stop

@section('page_name')
{{ trans('w-cms-laravel::header.media_formats_create') }}
@stop

@section('content')

<div class="container-fluid media_format-edit">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li><a href="{{ route('back_media_formats_index') }}">{{ trans('w-cms-laravel::header.media_formats') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.media_formats_create') }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.media_formats_create') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        {!! Form::open(array('url' => route('back_media_formats_store'), 'method' => 'post', 'enctype' => 'multipart/form-data')) !!}

            <div class="form-group">
                <label for="name">{{ trans('w-cms-laravel::media_formats.name') }}</label>
                <input autocomplete="off" type="text" class="form-control media_format-name" id="name" name="name" placeholder="{{ trans('w-cms-laravel::media_formats.name') }}" value="" />
            </div>

            <div class="form-group">
                <label for="alt">{{ trans('w-cms-laravel::media_formats.width') }}</label>
                <input autocomplete="off" type="text" class="form-control media_format-width" id="width" name="width" placeholder="{{ trans('w-cms-laravel::media_formats.width') }}" value="" />
            </div>

            <div class="form-group">
                <label for="height">{{ trans('w-cms-laravel::media_formats.height') }}</label>
                <input autocomplete="off" type="text" class="form-control media_format-height" id="height" name="height" placeholder="{{ trans('w-cms-laravel::media_formats.height') }}" value="" />
            </div>

            <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <a class="btn btn-default" href="{{ route('back_media_formats_index') }}" name="{{ trans('w-cms-laravel::header.media_formats') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        {!! Form::close() !!}

    </div>
</div>

@stop