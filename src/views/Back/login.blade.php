@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.login') }}
@stop

@section('content')

    <div class="container">
        <div class="col-md-4 col-md-offset-4" style="margin-top: 400px;">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><strong>{{ trans('w-cms-laravel::login.sign_in') }}</strong></h3></div>
                <div class="panel-body">
                     
                     <form role="form" action="{{ route('back_login_attempt') }}" method="post">
                        <div class="form-group">
                            <label for="login">{{ trans('w-cms-laravel::login.login') }}</label>
                            <input type="text" class="form-control" id="login" name="login" placeholder="{{ trans('w-cms-laravel::login.login') }}" value="" />
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('w-cms-laravel::login.password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('w-cms-laravel::login.password') }}" />
                        </div>
                    
                        <input type="submit" class="btn btn-primary" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@stop