@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.langs') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.langs') }}</li>
        </ol>

        <h1 class="lang-header">{{ trans('w-cms-laravel::header.langs') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($langs)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('w-cms-laravel::langs.name') }}</th>
                    <th>{{ trans('w-cms-laravel::langs.prefix') }}</th>
                    <th>{{ trans('w-cms-laravel::langs.is_default') }}</th>
                    <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($langs as $lang)
                <tr>
                    <td>{{{ $lang->ID or ''}}}</td>
                    <td>{{ $lang->name }}</td>
                    <td>{{ $lang->prefix }}</td>
                    <td>{{ $lang->is_default }}</td>
                    <td>
                        <a class="btn btn-default" href="{{ route('back_langs_edit', array($lang->ID)) }}" title="{{ $lang->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                        <a class="btn btn-danger" href="{{ route('back_langs_delete', array($lang->ID)) }}" title="{{ $lang->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{ trans('w-cms-laravel::langs.no_lang_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_langs_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
    </div>
</div>

@stop