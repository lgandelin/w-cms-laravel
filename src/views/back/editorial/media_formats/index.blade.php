@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.media_formats') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.media_formats') }}</li>
        </ol>

        <h1 class="media_format-header">{{ trans('w-cms-laravel::header.media_formats') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($media_formats)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('w-cms-laravel::media_formats.name') }}</th>
                    <th>{{ trans('w-cms-laravel::media_formats.width') }}</th>
                    <th>{{ trans('w-cms-laravel::media_formats.height') }}</th>
                    <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($media_formats as $media_format)
                <tr>
                    <td>{{{ $media_format->ID or '' }}}</td>
                    <td>{{ $media_format->name }}</td>
                    <td>{{ $media_format->width}}</td>
                    <td>{{ $media_format->height}}</td>
                    <td>
                        <a class="btn btn-default" href="{{ route('back_media_formats_edit', array($media_format->ID)) }}" title="{{ $media_format->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                        <a class="btn btn-danger" href="{{ route('back_media_formats_delete', array($media_format->ID)) }}" title="{{ $media_format->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{ trans('w-cms-laravel::media_formats.no_media_format_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_media_formats_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
    </div>
</div>

@stop