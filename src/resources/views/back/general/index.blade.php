@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.users') }}
@stop

@section('content')
    
    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::header.general') }}</li>
            </ol>

            <h1 class="page-header">{{ trans('w-cms-laravel::header.general') }}</h1>
             
            <ul class="shortcuts">
                <li>
                    <a href="{{ route('back_users_index') }}">
                        <span class="icon glyphicon glyphicon glyphicon-user"></span>
                          {{ trans('w-cms-laravel::header.users') }} 
                      </a>
                  </li>

                <li>
                    <a href="{{ route('back_users_index') }}">
                        <span class="icon glyphicon glyphicon glyphicon-lock"></span>
                        {{ trans('w-cms-laravel::header.roles') }}
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('back_langs_index') }}">
                        <span class="icon glyphicon glyphicon glyphicon-flag"></span>
                        {{ trans('w-cms-laravel::header.langs') }}
                    </a>
                </li>
            </div>
            
        </div>
    </div>

@stop