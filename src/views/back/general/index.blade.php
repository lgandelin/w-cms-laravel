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