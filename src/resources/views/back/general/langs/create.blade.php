@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.langs_create') }} > {{ trans('w-cms-laravel::langs.new_lang') }}
@stop

@section('content')

    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li><a href="{{ route('back_langs_index') }}">{{ trans('w-cms-laravel::header.langs') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::langs.new_lang') }}</li>
            </ol>

            <h1 class="page-header">{{ trans('w-cms-laravel::titles.langs_create') }}</h1>
            
            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            {!! Form::open(array('url' => route('back_langs_store'), 'method' => 'post')) !!}

                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::langs.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::langs.name') }}" />
                </div>

                <div class="form-group">
                    <label for="prefix">{{ trans('w-cms-laravel::langs.prefix') }}</label>
                    <input type="text" class="form-control" id="prefix" name="prefix" placeholder="{{ trans('w-cms-laravel::langs.prefix') }}" />
                </div>

                <div class="form-group">
                    <label for="is_default">{{ trans('w-cms-laravel::langs.is_default') }}</label>
                    Yes <input type="radio" id="is_default" name="is_default" value="1" />
                    No <input type="radio" id="is_default" name="is_default" value="0" />
                </div>
                
                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_langs_index') }}" title="{{ trans('w-cms-laravel::header.langs') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

            {!! Form::close() !!}
            
        </div>
    </div>

@stop