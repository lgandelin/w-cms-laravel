@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.dashboard') }}
@stop

@section('content')

    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li class="active">{{ trans('w-cms-laravel::header.dashboard') }}</li>
            </ol>

            <h1 class="page-header">{{ trans('w-cms-laravel::header.dashboard') }}</h1>

            <ul class="shortcuts">
                <li>
                    <a href="{{ route('back_pages_index') }}">
                          <img class="thumbnail" src="http://placehold.it/150x150/8BB58E/FFFFFF" />
                          {{ trans('w-cms-laravel::header.pages') }} 
                      </a>
                  </li>

                <li>
                    <a href="{{ route('back_pages_index') }}">
                        <img class="thumbnail" src="http://placehold.it/150x150/F2192C/FFFFFF" />
                        {{ trans('w-cms-laravel::header.articles') }}
                    </a>
                </li>
            </div>

        </div>
    </div>

@stop