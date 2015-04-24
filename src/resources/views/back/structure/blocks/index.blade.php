@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.blocks') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li><a href="{{ route('back_structure') }}">{{ trans('w-cms-laravel::header.structure') }}</a></li>
            <li><a href="{{ route('back_global_blocks_index') }}">{{ trans('w-cms-laravel::header.blocks') }}</a></li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.blocks') }}</h1>

        @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($blocks)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('w-cms-laravel::blocks.name') }}</th>
                    <th>{{ trans('w-cms-laravel::blocks.type') }}</th>
                    <th>{{ trans('w-cms-laravel::generic.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($blocks as $block)
                <tr>
                    <td>{{{ $block->ID or '' }}}</td>
                    <td>{{ $block->name }}</td>
                    <td>{{ strtoupper($block->type) }}</td>
                    <td>
                        <a class="btn btn-default" href="{{ route('back_global_blocks_edit', array($block->ID)) }}" title="{{ $block->name }}">{{ trans('w-cms-laravel::generic.edit') }}</a>
                        <a class="btn btn-danger" href="{{ route('back_global_blocks_delete', array($block->ID)) }}" title="{{ $block->name }}">{{ trans('w-cms-laravel::generic.delete') }}</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{ trans('w-cms-laravel::blocks.no_block_created_yet') }}
        @endif

        <a class="btn btn-primary" href="{{ route('back_global_blocks_create') }}" title="{{ trans('w-cms-laravel::generic.create') }}">{{ trans('w-cms-laravel::generic.create') }}</a>
    </div>
</div>

@stop