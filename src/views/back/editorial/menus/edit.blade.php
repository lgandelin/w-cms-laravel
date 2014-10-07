@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.menus_edit') }} > {{ $menu->name }}
@stop

@section('javascripts')
    <script type="text/javascript">
        var route_menu_items_create = "{{ route('back_menu_items_create') }}";
        var route_menu_items_update = "{{ route('back_menu_items_update') }}";
        var route_menu_items_delete = "{{ route('back_menu_items_delete') }}";
    </script>

    {{ HTML::script('packages/webaccess/w-cms-laravel/back/js/menus.js') }}
@stop

@section('content')

    <div class="container-fluid">
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
                    <div class="form-group">
                        <label for="name">{{ trans('w-cms-laravel::menus.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::menus.name') }}" value="{{ $menu->name }}" />
                    </div>

                    <div class="form-group">
                        <label for="identifier">{{ trans('w-cms-laravel::menus.identifier') }}</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::menus.identifier') }}" value="{{ $menu->identifier }}" />
                    </div>

                    <div class="form-group">
                        <label for="items">{{ trans('w-cms-laravel::menus.items') }}</label>
                        
                        @if ($menu->items):
                            @foreach ($menu->items as $item)

                                <div class="form-inline">
                                    <label for="items_label[]">{{ trans('w-cms-laravel::menus.item_label') }}</label>
                                    <input type="text" class="form-control" name="items_label[]" value="{{ $item->label }}" autocomplete="off" />
                                    <label for="items_order[]">{{ trans('w-cms-laravel::menus.item_order') }}</label>
                                    <input type="text" class="form-control" name="items_order[]" value="{{ $item->order }}" autocomplete="off" />
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
                            <label for="items_order[]">{{ trans('w-cms-laravel::menus.item_order') }}</label>
                            <input type="text" class="form-control" name="items_order[]" autocomplete="off" />
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
                        <label for="items_order[]">{{ trans('w-cms-laravel::menus.item_order') }}</label>
                        <input type="text" class="form-control" name="items_order[]" autocomplete="off" />
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
                    </div>
                    
                    <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                    <a class="btn btn-default" href="{{ route('back_menus_index') }}" title="{{ trans('w-cms-laravel::header.menus') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>

                    <input type="hidden" name="ID" value="{{ $menu->ID }}" />
                </form>
            @else
                {{ trans('w-cms-laravel::menus.not_found') }}
            @endif
            
        </div>
    </div>

@stop