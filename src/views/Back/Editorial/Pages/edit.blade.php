@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_edit') }} > {{{ $page->name or '' }}}
@stop

@section('javascripts')
	{{ HTML::script('packages/webaccess/w-cms-laravel/back/js/pages.js') }}
@stop

@section('content')

	<div class="container-fluid pages-interface">
		<div class="row main">
			
		    <ol class="breadcrumb">
				<li><a href="{{ route('back') }}">{{ trans('w-cms-laravel::header.dashboard') }}</a></li>
				<li><a href="{{ route('back_editorial') }}">{{ trans('w-cms-laravel::header.editorial') }}</a></li>
				<li><a href="{{ route('back_pages_index') }}">{{ trans('w-cms-laravel::header.pages') }}</a></li>
				<li class="active">{{{ $page->name or '' }}}</li>
			</ol>

			<h1 class="page-header">{{ trans('w-cms-laravel::header.pages_edit') }}</h1>
			
			@if (isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            
			@if ($page)

                <ul class="nav nav-tabs tab-navigation" role="tablist">
                    <li class="active"><a href="#content" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.content') }}</a></li>
                    <li><a href="#structure" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.structure') }}</a></li>
                    <li><a href="#versions" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.versions') }}</a></li>
                    <li><a href="#seo" role="tab" data-toggle="tab">{{ trans('w-cms-laravel::pages.seo') }}</a></li>
                </ul>

                <div class="tab-content">

                    <!-- CONTENT -->
                    <div class="tab-pane active" id="content">

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">{{ trans('w-cms-laravel::pages.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('w-cms-laravel::pages.name') }}" value="{{ $page->name }}" autocomplete="off" />
                        </div>
                        <!-- Name -->

                        <!-- Identifier -->
                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.identifier') }}</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" placeholder="{{ trans('w-cms-laravel::pages.identifier') }}" value="{{ $page->identifier }}" autocomplete="off" />
                        </div>
                        <!-- Identifier -->

                        <!-- Save -->
                        <div class="form-group">
                            <input type="button" data-id="{{ $page->ID }}" class="page-content-save-infos btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                            <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
                        </div>
                        <!-- Save -->

                        <!-- Blocks content -->
                        <div class="form-group">
                            <p><strong>{{ trans('w-cms-laravel::pages.content') }}</strong></p>

                            @if (isset($page->areas))
                                @foreach ($page->areas as $area)
                                <div class="area" data-id="{{ $area->ID }}">
                                    <span class="title"><span class="area_name">{{ $area->name }}</span></span>

                                    <div class="content">
                                        @foreach ($area->blocks as $block)
                                        <div class="block" data-id="{{ $block->ID }}">
                                            <span class="title"><span class="block_name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span></span>

                                            <div class="content">
                                                @if ($block->type == 'html')
                                                <textarea class="ckeditor" id="editor{{ $block->ID }}" name="editor{{ $block->ID }}">{{ $block->html }}</textarea>
                                                @endif

                                                <!-- Save -->
                                                <div class="submit_wrapper">
                                                    <input type="button" data-id="{{ $block->ID }}" class="page-content-save-block btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                                    <input type="button" data-id="{{ $block->ID }}" class="page-content-close-block btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                                                </div>
                                                <!-- Save -->

                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Blocks content -->
                    </div>
                    <!-- CONTENT -->



                    <!-- STRUCTURE -->
                    <div class="tab-pane" id="structure">

                        <p><strong>{{ trans('w-cms-laravel::pages.structure') }}</strong></p>

                        @if (isset($page->areas))
                            <div class="row">
                                @foreach ($page->areas as $area)
                                    <div data-id="{{ $area->ID }}" class="area col-xs-{{ $area->width }}">
                                        <div class="area_color">
                                            <span class="title">
                                                <span class="area_name">{{ $area->name }}</span> <span class="area_width">[<span class="width_value">{{ $area->width }}</span>]</span>
                                                <span data-id="{{ $area->ID }}" class="area-delete glyphicon glyphicon-remove"></span>
                                                <span data-id="{{ $area->ID }}" class="area-update glyphicon glyphicon-pencil"></span>
                                            </span>

                                            @foreach ($area->blocks as $block)
                                            <div data-id="{{ $block->ID }}" class="block col-xs-{{ $block->width}}">
                                                <div class="block_color">
                                                    <span class="title">
                                                        <span class="name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span> [<span class="width_value">{{ $block->width }}</span>]

                                                        <span data-id="{{ $block->ID }}" class="block-delete glyphicon glyphicon-remove"></span>
                                                        <span data-id="{{ $block->ID }}" class="block-update glyphicon glyphicon-pencil"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- UPDATE BLOCK FORM -->
                        <div class="update-block-form">
                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.block_name') }}" value="" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.block_width') }}" value="" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.block_height') }}" value="" />
                            </div>
                            <!-- Height -->

                            <!-- Type -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_type') }}</label>
                                <select class="type">
                                    <option value="">Choose a type</option>
                                    <option value="html">HTML</option>
                                </select>
                            </div>
                            <!-- Type -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.block_class') }}" value="" />
                            </div>
                            <!-- Class-->

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" data-id="{{ $block->ID }}" class="page-content-update-block btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" data-id="{{ $block->ID }}" class="page-content-close-update-block btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                            </div>
                            <!-- Save -->

                        </div>
                        <!-- UPDATE BLOCK FORM -->

                        <!-- UPDATE AREA FORM -->
                        <div class="update-area-form">
                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.area_name') }}" value="" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.area_width') }}" value="" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.area_height') }}" value="" />
                            </div>
                            <!-- Height -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.area_class') }}" value="" />
                            </div>
                            <!-- Class-->

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" data-id="{{ $area->ID }}" class="page-content-update-area btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" data-id="{{ $area->ID }}" class="page-content-close-update-area btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                            </div>
                            <!-- Save -->

                        </div>
                        <!-- UPDATE AREA FORM -->
                        

                    </div>
                    <!-- STRUCTURE -->



                    <!-- VERSIONS -->
                    <div class="tab-pane" id="versions">

                    </div>
                    <!-- VERSIONS -->



                    <!-- SEO -->
                    <div class="tab-pane" id="seo">

                        <!-- Uri -->
                        <div class="form-group">
                            <label for="uri">{{ trans('w-cms-laravel::pages.uri') }}</label>
                            <input type="text" class="form-control" id="uri" name="uri" placeholder="{{ trans('w-cms-laravel::pages.uri') }}" value="{{ $page->uri }}" autocomplete="off" />
                        </div>
                        <!-- Uri -->

                        <!-- Meta title -->
                        <div class="form-group">
                            <label for="meta_title">{{ trans('w-cms-laravel::pages.meta_title') }}</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="{{ trans('w-cms-laravel::pages.meta_title') }}" value="{{ $page->meta_title }}" autocomplete="off" />
                        </div>
                        <!-- Meta title -->

                        <!-- Meta description -->
                        <div class="form-group">
                            <label for="meta_description">{{ trans('w-cms-laravel::pages.meta_description') }}</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="5" autocomplete="off">{{ $page->meta_description }}</textarea>
                        </div>
                        <!-- Meta description -->

                        <!-- Meta keywords -->
                        <div class="form-group">
                            <label for="meta_keywords">{{ trans('w-cms-laravel::pages.meta_keywords') }}</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="{{ trans('w-cms-laravel::pages.meta_keywords') }}" value="{{ $page->meta_keywords }}" autocomplete="off" />
                        </div>
                        <!-- Meta keywords -->

                        <!-- Save -->
                        <div class="form-group">
                            <input type="button" data-id="{{ $page->ID }}" class="page-content-save-seo btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                            <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
                        </div>
                        <!-- Save -->
                    </div>
                    <!-- SEO -->

                </div>


			@else
				{{ trans('w-cms-laravel::pages.not_found') }}
			@endif
			
		</div>
	</div>

@stop