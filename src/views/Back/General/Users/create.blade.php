@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.users_create') }} > {{ trans('w-cms-laravel::users.new_user') }}
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
                <li><a href="#">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="#">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li><a href="{{ route('back_users_index') }}">{{ trans('w-cms-laravel::header.users') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::users.new_user') }}</li>
            </ol>

            <h1 class="user-header">{{ trans('w-cms-laravel::titles.users_create') }}</h1>
            
            <form role="form" action="{{ route('back_users_store') }}" method="post">
                <div class="form-group">
                    <label for="login">{{ trans('w-cms-laravel::users.login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="{{ trans('w-cms-laravel::users.login') }}" />
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('w-cms-laravel::users.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('w-cms-laravel::users.password') }}" />
                </div>

                <div class="form-group">
                    <label for="last_name">{{ trans('w-cms-laravel::users.last_name') }}</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{ trans('w-cms-laravel::users.last_name') }}" />
                </div>

                <div class="form-group">
                    <label for="first_name">{{ trans('w-cms-laravel::users.first_name') }}</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{ trans('w-cms-laravel::users.first_name') }}" />
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('w-cms-laravel::users.email') }}</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="{{ trans('w-cms-laravel::users.email') }}" />
                </div>
                
                <input type="submit" class="btn btn-primary" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_users_index') }}" title="{{ trans('w-cms-laravel::header.users') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
            </form>
            
        </div>
    </div>

@stop