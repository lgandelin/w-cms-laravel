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
                <li><a href="#">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::header.users') }}</li>
            </ol>

            <h1 class="user-header">{{ trans('w-cms-laravel::header.users') }}</h1>
            
            @if ($users)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('w-cms-laravel::users.login') }}</th>
                            <th>{{ trans('w-cms-laravel::users.name') }}</th>
                            <th>{{ trans('w-cms-laravel::users.email') }}</th>
                            <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a class="btn btn-default" href="{{ route('back_users_edit', array($user->login)) }}" title="{{ $user->login }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                                <a class="btn btn-danger" href="{{ route('back_users_delete', array($user->login)) }}" title="{{ $user->login }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                {{ trans('w-cms-laravel::users.no_user_created_yet') }}
            @endif
            
            <a class="btn btn-primary" href="{{ route('back_users_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
        </div>
    </div>

@stop