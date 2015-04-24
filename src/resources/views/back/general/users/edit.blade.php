@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.users_edit') }} > {{ $user->login }} ({{ $user->last_name }} {{ $user->last_name }})
@stop

@section('content')
    
    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li><a href="{{ route('back_users_index') }}">{{ trans('w-cms-laravel::header.users') }}</a></li>
                <li class="active">{{ $user->login }} ({{ $user->last_name }} {{ $user->first_name }})</li>
            </ol>

            <h1 class="page-header">{{ trans('w-cms-laravel::header.users_edit') }}</h1>
            
            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
            @if ($user)

            {!! Form::open(array('url' => route('back_users_update'), 'method' => 'post')) !!}

                <div class="form-group">
                    <label for="login">{{ trans('w-cms-laravel::users.login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="{{ trans('w-cms-laravel::users.login') }}" value="{{ $user->login }}" />
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('w-cms-laravel::users.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('w-cms-laravel::users.password') }}" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label for="last_name">{{ trans('w-cms-laravel::users.last_name') }}</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{ trans('w-cms-laravel::users.last_name') }}" value="{{ $user->last_name }}" />
                </div>

                <div class="form-group">
                    <label for="first_name">{{ trans('w-cms-laravel::users.first_name') }}</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{ trans('w-cms-laravel::users.first_name') }}" value="{{ $user->first_name }}" />
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('w-cms-laravel::users.email') }}</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="{{ trans('w-cms-laravel::users.email') }}" value="{{ $user->email }}" />
                </div>

                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <a class="btn btn-default" href="{{ route('back_users_index') }}" title="{{ trans('w-cms-laravel::header.users') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
                
                <input type="hidden" name="ID" value="{{ $user->ID }}" />

            {!! Form::close() !!}
            @else
                {{ trans('w-cms-laravel::users.not_found') }}
            @endif
            
        </div>
    </div>

@stop