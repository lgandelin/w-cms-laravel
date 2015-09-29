@extends('w-cms-laravel::back.master')

@section('page_title')
    {{ trans('w-cms-laravel::titles.menus') }}
@stop

@section('content')
    
    <div class="container-fluid">
        <div class="row main">
            
            <ol class="breadcrumb">
                <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
                <li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
                <li class="active">{{ trans('w-cms-laravel::header.menus') }}</li>
            </ol>

            <h1 class="page-header">{{ trans('w-cms-laravel::header.menus') }}</h1>
                
            @if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
            @if ($menus)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('w-cms-laravel::menus.name') }}</th>
                                <th>{{ trans('w-cms-laravel::menus.identifier') }}</th>
                                <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                            <tr>
                                <td>{{{ $menu->ID or '' }}}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->identifier }}</td>
                                <td>
                                    <a class="btn btn-default" href="{{ route('back_menus_edit', array($menu->ID)) }}" title="{{ $menu->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                                    <a class="btn btn-default" href="{{ route('back_menus_duplicate', array($menu->ID)) }}" title="{{ $menu->name }}">{{ trans('w-cms-laravel::generic.duplicate') }}</a>
                                    <a class="btn btn-danger" href="{{ route('back_menus_delete', array($menu->ID)) }}" title="{{ $menu->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>{{ trans('w-cms-laravel::menus.no_menu_created_yet') }}</p>
            @endif
            
            <a class="btn btn-primary" href="{{ route('back_menus_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
        </div>
    </div>

@stop