@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.menus_edit') }} > {{ $menu->name }}
@stop

@section('javascripts')
    <script type="text/javascript">
        var route_menu_items_create = "{{ route('back_menu_items_create') }}";
        var route_menu_items_get_infos = "{{ route('back_menu_items_get_infos') }}";
        var route_menu_items_update_infos = "{{ route('back_menu_items_update_infos') }}";
        var route_menu_items_update_order = "{{ route('back_menu_items_update_order') }}";
        var route_menu_items_delete = "{{ route('back_menu_items_delete') }}";
    </script>

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    {{ HTML::script('packages/webaccess/w-cms-laravel/back/js/menus.js') }}
@stop

@section('content')

    <div class="container-fluid menus-interface">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li><a href="{{ route('back_menus_index') }}">{{ trans('w-cms-laravel::header.menus') }}</a></li>
                <li class="active">{{ $menu->name }}</li>
            </ol>

            <h1 class="menu-header">{{ trans('w-cms-laravel::header.menus_edit') }}</h1>
                
            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
            @if ($menu)
                <form role="form" action="{{ route('back_menus_update') }}" method="post">

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">{{ trans('w-cms-laravel::menus.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::menus.name') }}" value="{{ $menu->name }}" />
                    </div>
                    <!-- Name -->

                    <!-- Identifier -->
                    <div class="form-group">
                        <label for="identifier">{{ trans('w-cms-laravel::menus.identifier') }}</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::menus.identifier') }}" value="{{ $menu->identifier }}" />
                    </div>
                    <!-- Identifier -->

                    <!-- Save -->
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                        <a class="btn btn-default" href="{{ route('back_menus_index') }}" title="{{ trans('w-cms-laravel::header.menus') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                        <input class="menu-id" type="hidden" name="ID" value="{{ $menu->ID }}" />
                    </div>
                    <!-- Save -->

                </form>

                <!--<div class="form-group">
                    <label for="items">{{ trans('w-cms-laravel::menus.items') }}</label>

                    @if ($menu->items):
                        @foreach ($menu->items as $item)

                            <div class="form-inline">
                                <label for="items_label[]">{{ trans('w-cms-laravel::menus.item_label') }}</label>
                                <input type="text" class="form-control" name="items_label[]" value="{{ $item->label }}" autocomplete="off" />
                                <label for="items_page[]">{{ trans('w-cms-laravel::menus.item_page') }}</label>
                                <select name="items_page[]" class="form-control" autocomplete="off">
                                    <option>{{ trans('w-cms-laravel::menus.choose_page') }}</option>
                                    @if ($pages)
                                         @foreach ($pages as $page)
                                            <option value="{{ $page->ID }}" @if ($item->page_id == $page->ID)selected="selected"@endif>{{ $page->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="button" class="btn btn-primary btn-update" value="{{ trans('w-cms-laravel::generic.edit') }}" data-item-id="{{ $item->ID }}" />
                                <input type="button" class="btn btn-danger btn-delete" value="{{ trans('w-cms-laravel::generic.delete') }}" data-item-id="{{ $item->ID }}" />
                            </div>
                        @endforeach
                    @endif

                    <div style="display:none" class="form-inline new-menu-pattern">
                        <label for="items_label[]">{{ trans('w-cms-laravel::menus.item_label') }}</label>
                        <input type="text" class="form-control" name="items_label[]" autocomplete="off" />
                        <label for="items_page[]">{{ trans('w-cms-laravel::menus.item_page') }}</label>
                        <select name="items_page[]" class="form-control" autocomplete="off">
                            <option value="">{{ trans('w-cms-laravel::menus.choose_page') }}</option>
                            @if ($pages)
                                @foreach ($pages as $page)
                                    <option value="{{ $page->ID }}">{{ $page->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="button" class="btn btn-primary btn-update" value="{{ trans('w-cms-laravel::generic.edit') }}" />
                        <input type="button" class="btn btn-danger btn-delete" value="{{ trans('w-cms-laravel::generic.delete') }}" />
                    </div>

                </div>

                <div class="form-group form-inline">
                    <label for="items_label[]">{{ trans('w-cms-laravel::menus.item_label') }}</label>
                    <input type="text" class="form-control" name="items_label[]" autocomplete="off" />
                    <label for="items_page[]">{{ trans('w-cms-laravel::menus.item_page') }}</label>
                    <select name="items_page[]" class="form-control" autocomplete="off">
                        <option>{{ trans('w-cms-laravel::menus.choose_page') }}</option>
                        @if ($pages)
                            @foreach ($pages as $page)
                                <option value="{{ $page->ID }}">{{ $page->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="button" class="btn btn-primary btn-create" value="{{ trans('w-cms-laravel::generic.create') }}" />
                </div>-->

                <div class="form-group">
                    <label for="items">{{ trans('w-cms-laravel::menus.items') }}</label>

                    <div style="overflow: hidden">
                        <div class="items-order">
                            <div class="menu-items-wrapper">
                                @if ($menu->items)
                                    @foreach ($menu->items as $item)
                                    <div id="mi-{{ $item->ID }}" class="menu_item">
                                        <span class="title">
                                            <span class="menu_item_label">{{ $item->label }}</span>
                                            <span data-id="{{ $item->ID }}" class="menu-item-delete glyphicon glyphicon-remove"></span>
                                            <span data-id="{{ $item->ID }}" class="menu-item-move glyphicon glyphicon-move"></span>
                                            <span data-id="{{ $item->ID }}" class="menu-item-display @if ($item->display == 0) menu-item-hidden @endif glyphicon glyphicon-eye-open"></span>
                                            <span data-id="{{ $item->ID }}" class="menu-item-update glyphicon glyphicon-pencil"></span>
                                        </span>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success btn-create-menu-item">{{ trans('w-cms-laravel::menus.add_menu_item') }}</button>
                            </div>

                        </div>


                        <div class="menu-item-form">

                            <!-- CREATE MENU ITEM FORM -->
                            <div class="create-menu-item-form" style="display:none">

                                <!-- Label -->
                                <div class="form-group">
                                    <label>{{ trans('w-cms-laravel::menus.item_label') }}</label>
                                    <input type="text" class="form-control menu-item-label" placeholder="{{ trans('w-cms-laravel::menus.item_label') }}" autocomplete="off" />
                                </div>
                                <!-- Label -->

                                <!-- Save -->
                                <div class="submit_wrapper">
                                    <input type="button" class="menu-valid-create-menu-item btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                    <input type="button" class="menu-close-create-menu-item btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                                </div>
                                <!-- Save -->

                            </div>
                            <!-- CREATE MENU ITEM FORM -->


                            <!-- UPDATE MENU ITEM FORM -->
                            <div class="update-menu-item-form" style="display:none">

                                <!-- Label -->
                                <div class="form-group">
                                    <label>{{ trans('w-cms-laravel::menus.item_label') }}</label>
                                    <input type="text" class="form-control menu-item-label" placeholder="{{ trans('w-cms-laravel::menus.item_label') }}" autocomplete="off" />
                                </div>
                                <!-- Label -->

                                <!-- Save -->
                                <div class="submit_wrapper">
                                    <input type="button" class="menu-valid-update-menu-item btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                    <input type="button" class="menu-close-update-menu-item btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                                </div>
                                <!-- Save -->

                            </div>
                            <!-- UPDATE MENU ITEM FORM -->

                        </div>
                    </div>
                </div>



            @else
                {{ trans('w-cms-laravel::menus.not_found') }}
            @endif
            
        </div>
    </div>

@stop