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

                        <!-- DASHBOARD -->
	                    <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                        <!-- DASHBOARD -->

                        <!-- EDITORIAL -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('w-cms-laravel::header.editorial') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('back_editorial') }}"><span class="icon glyphicon glyphicon-pencil"></span>{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('back_pages_index') }}"><span class="icon glyphicon glyphicon glyphicon-list-alt"></span>{{ trans('w-cms-laravel::header.pages') }}</a></li>
                                <li><a href="{{ route('back_articles_index') }}"><span class="icon glyphicon glyphicon glyphicon-file"></span>{{ trans('w-cms-laravel::header.articles') }}</a></li>
                                <li><a href="{{ route('back_menus_index') }}"><span class="icon glyphicon glyphicon glyphicon-align-justify"></span>{{ trans('w-cms-laravel::header.menus') }}</a></li>
                            </ul>
                        </li>
                        <!-- EDITORIAL -->

                        <!-- STRUCTURE -->
	                    <li><a href="#">{{ trans('w-cms-laravel::header.structure') }}</a></li>
                        <!-- STRUCTURE -->

                        <!-- GENERAL -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('w-cms-laravel::header.general') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('back_general') }}"><span class="icon glyphicon glyphicon glyphicon-cog"></span>{{ trans('w-cms-laravel::header.general') }}</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('back_users_index') }}"><span class="icon glyphicon glyphicon glyphicon-user"></span>{{ trans('w-cms-laravel::header.users') }}</a></li>
                            </ul>
                        </li>
                        <!-- GENERAL -->

                        <!-- ADMINISTRATION -->
	                    <li><a href="#">{{ trans('w-cms-laravel::header.administration') }}</a></li>
                        <!-- ADMINISTRATION -->
	                </ul>
	            </div>
	        </div>
	    </div>

        @yield('content')

    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/bootstrap/js/bootstrap.min.js') }}
		{{ HTML::script('packages/webaccess/w-cms-laravel/back/vendor/ckeditor/ckeditor.js') }}

        <script type="text/javascript">
            var route_pages_update_infos = "{{ route('back_pages_update_infos') }}";
            var route_pages_update_seo = "{{ route('back_pages_update_seo') }}";

            var route_areas_get_infos = "{{ route('back_areas_get_infos') }}";
            var route_areas_update_infos = "{{ route('back_areas_update_infos') }}";
            var route_areas_create = "{{ route('back_areas_create') }}";
            var route_areas_update_order = "{{ route('back_areas_update_order') }}";
            var route_areas_display = "{{ route('back_areas_display') }}";
            var route_areas_delete = "{{ route('back_areas_delete') }}";

            var route_blocks_get_infos = "{{ route('back_blocks_get_infos') }}";
            var route_blocks_update_infos = "{{ route('back_blocks_update_infos') }}";
            var route_blocks_create = "{{ route('back_blocks_create') }}";
            var route_blocks_update_content = "{{ route('back_blocks_update_content') }}";
            var route_blocks_update_order = "{{ route('back_blocks_update_order') }}";
            var route_blocks_display = "{{ route('back_blocks_display') }}";
            var route_blocks_delete = "{{ route('back_blocks_delete') }}";

            var route_menu_items_create = "{{ route('back_menu_items_create') }}";
            var route_menu_items_get_infos = "{{ route('back_menu_items_get_infos') }}";
            var route_menu_items_update_infos = "{{ route('back_menu_items_update_infos') }}";
            var route_menu_items_update_order = "{{ route('back_menu_items_update_order') }}";
            var route_menu_items_display = "{{ route('back_menu_items_display') }}";
            var route_menu_items_delete = "{{ route('back_menu_items_delete') }}";
        </script>

		@yield('javascripts')
    </body>
</html>