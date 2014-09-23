@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.menus_create') }}
@stop

@section('content')

    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li><a href="{{ route('back_menus_index') }}">{{ trans('w-cms-laravel::header.menus') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::menus.new_menu') }}</li>
            </ol>

            <h1 class="menu-header">{{ trans('w-cms-laravel::titles.menus_create') }}</h1>
            
            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            <form role="form" action="{{ route('back_menus_store') }}" method="post">

                <div class="form-group">
                    <label for="name">{{ trans('w-cms-laravel::menus.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::menus.name') }}" value="{{{ $menu->name or '' }}}" />
                </div>

                <div class="form-group">
                    <label for="identifier">{{ trans('w-cms-laravel::menus.identifier') }}</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::menus.identifier') }}" value="{{{ $menu->identifier or ''}}}" />
                </div>

                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_menus_index') }}" title="{{ trans('w-cms-laravel::header.menus') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
            </form>
            
        </div>
    </div>

@stop