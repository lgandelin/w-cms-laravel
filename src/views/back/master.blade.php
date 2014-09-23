<html>
    <head>
		<meta charset="UTF-8">
		<title>@yield('page_title')</title>
		{{ HTML::style('packages/webaccess/w-cms-laravel/back/vendor/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('packages/webaccess/w-cms-laravel/back/vendor/bootstrap/css/bootstrap-theme.min.css') }}
		{{ HTML::style('packages/webaccess/w-cms-laravel/back/css/style.css') }}

	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>

		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	        <div class="container-fluid">
	            <div class="navbar-header">
	                <a class="navbar-brand" href="{{ route('back') }}">{{ trans('w-cms-laravel::header.title') }}</a>
	                @if ($user)
	                    <ul class="nav navbar-nav">
	                        <li><a href="#">{{ trans('w-cms-laravel::header.welcome') }} {{ $user->first_name }} !</a></li>
	                        <li>
	                            <a href="{{ route('back_logout') }}">{{ trans('w-cms-laravel::header.logout') }}</a>
	                        </li>
	                    </ul>
	                @endif
	            </div>
	            <div class="navbar-collapse collapse">
	                <ul class="nav navbar-nav navbar-right">
	                    <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
	                    <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
	                    <li><a href="#">{{ trans('w-cms-laravel::header.structure') }}</a></li>
	                    <li><a href="{{ route('back_general') }}">{{ trans('w-cms-laravel::header.general') }}</a></li>
	                    <li><a href="#">{{ trans('w-cms-laravel::header.administration') }}</a></li>
	                </ul>
	            </div>
	        </div>
	    </div>

        @yield('content')

    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/bootstrap/js/bootstrap.min.js') }}
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/ckeditor/ckeditor.js') }}

		@yield('javascripts')
    </body>
</html>