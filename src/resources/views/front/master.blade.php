<html>
    <head>
		<meta charset="UTF-8">
		<title>@yield('page_title')</title>
		{!! HTML::style('vendor/w-cms-laravel/front/vendor/bootstrap/css/bootstrap.css') !!}
		{!! HTML::style('vendor/w-cms-laravel/front/vendor/bootstrap/css/bootstrap-theme.css') !!}
        {!! HTML::style('vendor/w-cms-laravel/front/css/style.css') !!}
        @yield('styles')
		@yield('meta_description')
		@yield('meta_keywords')
	</head>
	<body>
        <div class="container">
            @yield('content')
        </div>
        @yield('scripts')
    </body>
</html>