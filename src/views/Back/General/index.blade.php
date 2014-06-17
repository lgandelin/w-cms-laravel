@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.users') }}
@stop

@section('content')

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">{{ trans('w-cms-laravel::header.title') }}</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                    <li><a href="#">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                    <li><a href="#">{{ trans('w-cms-laravel::header.structure') }}</a></li>
                    <li><a href="#">{{ trans('w-cms-laravel::header.general') }}</a></li>
                    <li><a href="#">{{ trans('w-cms-laravel::header.administration') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    
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
                          <img class="thumbnail" src="http://placehold.it/150x150/8BB58E/FFFFFF" />
                          {{ trans('w-cms-laravel::header.users') }} 
                      </a>
                  </li>

                <li>
                    <a href="{{ route('back_users_index') }}">
                        <img class="thumbnail" src="http://placehold.it/150x150/F2192C/FFFFFF" />
                        {{ trans('w-cms-laravel::header.roles') }}
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('back_users_index') }}">
                        <img class="thumbnail" src="http://placehold.it/150x150/F2192C/FFFFFF" />
                        {{ trans('w-cms-laravel::header.languages') }}
                    </a>
                </li>
            </div>
            
        </div>
    </div>

@stop