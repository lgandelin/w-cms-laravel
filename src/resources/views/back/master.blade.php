<html>
    <head>
		<meta charset="UTF-8">
		<title>@yield('page_title')</title>
		{!! HTML::style('vendor/w-cms-laravel/back/vendor/bootstrap/css/bootstrap.min.css') !!}
		{!! HTML::style('vendor/w-cms-laravel/back/vendor/bootstrap/css/bootstrap-theme.min.css') !!}
		{!! HTML::style('vendor/w-cms-laravel/back/css/style.css') !!}
        @yield('stylesheets')
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

                <div class="nav-bar-collapse pull-left" style="margin-left:30%">
                    <ul class="nav navbar-nav">
                        @foreach ($langs as $lang)
                            <li @if (Session::get('lang_id') == $lang->ID)class="active" @endif>
                                <a href="{{ route('back_lang_change', ['lang_id' => $lang->ID]) }}">
                                    <img src="{{ asset('vendor/w-cms-laravel/back/img/flags/' . $lang->code . '.png') }}" width="33" height="25" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
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
                                <li><a href="{{ route('back_pages_index') }}"><span class="icon glyphicon glyphicon-file"></span>{{ trans('w-cms-laravel::header.pages') }}</a></li>
                                <li><a href="{{ route('back_articles_index') }}"><span class="icon glyphicon glyphicon-font"></span>{{ trans('w-cms-laravel::header.articles') }}</a></li>
                                <li><a href="{{ route('back_menus_index') }}"><span class="icon glyphicon glyphicon-align-justify"></span>{{ trans('w-cms-laravel::header.menus') }}</a></li>
                                <li><a href="{{ route('back_medias_index') }}"><span class="icon glyphicon glyphicon-picture"></span>{{ trans('w-cms-laravel::header.medias') }}</a></li>
                                <li><a href="{{ route('back_media_formats_index') }}"><span class="icon glyphicon glyphicon-inbox"></span>{{ trans('w-cms-laravel::header.media_formats') }}</a></li>

                                @if ($editorial_menu_items)
                                    @foreach ($editorial_menu_items as $menu_item)
                                        <li><a href="{{ route($menu_item['route_name']) }}"><span class="icon glyphicon {{ $menu_item['class_name'] }}"></span>{{ $menu_item['label'] }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        <!-- EDITORIAL -->

                        <!-- STRUCTURE -->
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('w-cms-laravel::header.structure') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('back_structure') }}"><span class="icon glyphicon glyphicon-tower"></span>{{ trans('w-cms-laravel::header.structure') }}</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('back_global_blocks_index') }}"><span class="icon glyphicon glyphicon-th"></span>{{ trans('w-cms-laravel::header.blocks') }}</a></li>
                            </ul>
                        </li>-->
                        <!-- STRUCTURE -->

                        <!-- GENERAL -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('w-cms-laravel::header.general') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('back_general') }}"><span class="icon glyphicon glyphicon-cog"></span>{{ trans('w-cms-laravel::header.general') }}</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('back_users_index') }}"><span class="icon glyphicon glyphicon-user"></span>{{ trans('w-cms-laravel::header.users') }}</a></li>
                                <li><a href="{{ route('back_langs_index') }}"><span class="icon glyphicon glyphicon-flag"></span>{{ trans('w-cms-laravel::header.langs') }}</a></li>
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
		{!! HTML::script('vendor/w-cms-laravel/back/vendor/bootstrap/js/bootstrap.min.js') !!}
		{!! HTML::script('vendor/w-cms-laravel/back/vendor/ckeditor/ckeditor.js') !!}
		{!! HTML::script('vendor/w-cms-laravel/back/js/includes.js') !!}
		{!! HTML::script('vendor/w-cms-laravel/back/js/handlebars-v4.0.4.js') !!}
        {!! HTML::script('https://code.jquery.com/ui/1.11.3/jquery-ui.js') !!}
        {!! HTML::script('vendor/w-cms-laravel/back/js/medias.js') !!}

        <script type="text/javascript">
            var route_pages_update_infos = "{{ route('back_pages_update_infos') }}";
            var route_pages_update_seo = "{{ route('back_pages_update_seo') }}";
            var route_pages_clear_cache = "{{ route('back_pages_clear_cache') }}";

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

            var route_media_upload = "{{ route('back_medias_upload') }}";
            var route_media_store = "{{ route('back_medias_store') }}";
            var route_medias_delete = "{{ route('back_medias_delete') }}";
            var route_media_create_and_upload = "{{ route('back_medias_create_and_upload') }}";
            var route_media_crop = "{{ route('back_medias_crop') }}";
            var route_get_medias = "{{ route('back_medias_get') }}";
            var route_media_move_in_media_folder = "{{ route('back_medias_move_in_media_folder') }}";
            var route_media_folders_move_in_media_folder = "{{ route('back_media_folders_move_in_media_folder') }}";

            var route_medias_folder_create = "{{ route('back_media_folders_store') }}";
            var route_medias_folder_delete = "{{ route('back_media_folders_delete') }}";
        </script>

		@yield('javascripts')
    </body>
</html>