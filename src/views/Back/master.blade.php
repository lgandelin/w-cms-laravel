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
        @yield('content')

    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/bootstrap/js/bootstrap.min.js') }}
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/ckeditor/ckeditor.js') }}

		@yield('javascripts')
    </body>
</html>