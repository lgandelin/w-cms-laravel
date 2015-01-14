@extends('w-cms-laravel::back.master')

@section('page_title')
{{ trans('w-cms-laravel::titles.structure') }}
@stop

@section('content')

<div class="container-fluid">
    <div class="row main">

        <ol class="breadcrumb">
            <li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
            <li class="active">{{ trans('w-cms-laravel::header.structure') }}</li>
        </ol>

        <h1 class="page-header">{{ trans('w-cms-laravel::header.structure') }}</h1>

        <ul class="shortcuts">
            <li>
                <a href="{{ route('back_global_blocks_index') }}">
                    <span class="icon glyphicon glyphicon-th"></span>
                    {{ trans('w-cms-laravel::header.blocks') }}
                </a>
            </li>
    </div>

</div>
</div>

@stop