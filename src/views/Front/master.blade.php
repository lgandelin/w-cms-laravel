<html>
    <head>
		<meta charset="UTF-8">
		<title>@yield('page_title')</title>
		{{ HTML::style('packages/webaccess/w-cms-laravel/front/css/style.css') }}
		{{ HTML::style('packages/webaccess/w-cms-laravel/front/vendor/bootstrap/css/bootstrap.css') }}
		{{ HTML::style('packages/webaccess/w-cms-laravel/front/vendor/bootstrap/css/bootstrap-theme.css') }}

		@yield('meta_description')
		@yield('meta_keywords')
	</head>
	<body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>