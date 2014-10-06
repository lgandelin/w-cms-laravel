@extends('w-cms-laravel::back.master')

@section('page_title')
	{{ trans('w-cms-laravel::titles.pages_edit') }} > {{{ $page->name or '' }}}
@stop

@section('javascripts')
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
    </script>

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
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
                                        <div class="block" data-id="{{ $block->ID }}" data-type="{{ $block->type }}">
                                            <span class="title"><span class="block_name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span></span>

                                            <div class="content">
                                                @if ($block->type == 'html')
                                                    <textarea class="ckeditor" id="editor{{ $block->ID }}" name="editor{{ $block->ID }}">{{ $block->html }}</textarea>
                                                @elseif ($block->type == 'menu')
                                                    <div class="form-group">
                                                        <label for="identifier">{{ trans('w-cms-laravel::pages.block_menu') }}</label>
                                                        <select class="menu_id form-control" autocomplete="off">
                                                            <option value="">{{ trans('w-cms-laravel::pages.choose_menu') }}</option>
                                                            @if (isset($menus))
                                                                @foreach ($menus as $menu)
                                                                    <option value="{{ $menu->ID }}" @if ($block->menu_id == $menu->ID) selected="selected" @endif>{{ $menu->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                @elseif ($block->type == 'view_file')
                                                    <div class="form-group">
                                                        <label for="identifier">{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
                                                        <input type="text" class="form-control view_file" placeholder="{{ trans('w-cms-laravel::pages.view_file') }}" value="{{ $block->view_file }}" autocomplete="off" />
                                                    </div>
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

                    <div style="display:none;" id="select_menu_template">
                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_menu') }}</label>
                            <select class="menu_id form-control" autocomplete="off">
                                <option value="">{{ trans('w-cms-laravel::pages.choose_menu') }}</option>
                                @if (isset($menus))
                                @foreach ($menus as $menu)
                                <option value="{{ $menu->ID }}">{{ $menu->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div style="display:none" id="view_file_template">
                        <div class="form-group">
                            <label for="identifier">{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
                            <input type="text" class="form-control view_file" placeholder="{{ trans('w-cms-laravel::pages.block_view_file') }}" value="" autocomplete="off" />
                        </div>
                    </div>


                    <!-- STRUCTURE -->
                    <div class="tab-pane" id="structure">

                        <p><strong>{{ trans('w-cms-laravel::pages.structure') }}</strong></p>

                        <div class="row areas-wrapper">
                            @if (isset($page->areas))
                                @foreach ($page->areas as $area)
                                    <div id="a-{{ $area->ID }}" data-id="{{ $area->ID }}" class="area col-xs-{{ $area->width }}" data-width="{{ $area->width }}" data-display="{{ $area->display }}">
                                        <div class="area_color">
                                            <span class="title">
                                                <span class="area_name">{{ $area->name }}</span> <span class="area_width">[<span class="width_value">{{ $area->width }}</span>]</span>
                                                <span data-id="{{ $area->ID }}" class="area-delete glyphicon glyphicon-remove"></span>
                                                <span data-id="{{ $area->ID }}" class="area-move glyphicon glyphicon-move"></span>
                                                <span data-id="{{ $area->ID }}" class="area-display @if ($area->display == 0) area-hidden @endif glyphicon glyphicon-eye-open"></span>
                                                <span data-id="{{ $area->ID }}" class="area-update glyphicon glyphicon-pencil"></span>
                                                <span data-id="{{ $area->ID }}" class="area-create-block glyphicon glyphicon-plus"></span>
                                            </span>

                                            @foreach ($area->blocks as $block)
                                            <div id="b-{{ $block->ID }}" data-id="{{ $block->ID }}" class="block col-xs-{{ $block->width}}" data-width="{{ $block->width }}" data-display="{{ $block->display }}">
                                                <div class="block_color">
                                                    <span class="title">
                                                        <span class="name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span> [<span class="width_value">{{ $block->width }}</span>]

                                                        <span data-id="{{ $block->ID }}" class="block-delete glyphicon glyphicon-remove"></span>
                                                        <span data-id="{{ $block->ID }}" class="block-move glyphicon glyphicon-move"></span>
                                                        <span data-id="{{ $block->ID }}" class="block-display @if (!$block->display) block-hidden @endif glyphicon glyphicon-eye-open"></span>
                                                        <span data-id="{{ $block->ID }}" class="block-update glyphicon glyphicon-pencil"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Createa area -->
                        <div class="form-group">
                            <input type="button" data-id="{{ $page->ID }}" class="page-content-create-area btn btn-success" value="{{ trans('w-cms-laravel::pages.add_area') }}" />
                            <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
                        </div>
                        <!-- Createa area -->

                        <!-- CREATE AREA FORM -->
                        <div class="create-area-form">

                            <h2>Create an area</h2>

                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.area_name') }}" autocomplete="off" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.area_width') }}" autocomplete="off" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.area_height') }}" autocomplete="off" />
                            </div>
                            <!-- Height -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.area_class') }}" autocomplete="off" />
                            </div>
                            <!-- Class-->

                            <input type="hidden" class="page_id" value="{{ $page->ID }}" />

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" class="page-content-valid-create-area btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" class="page-content-close-create-area btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                            </div>
                            <!-- Save -->

                        </div>
                        <!-- CREATE AREA FORM -->
                        
                        
                        

                        <!-- CREATE BLOCK FORM -->
                        <div class="create-block-form">

                            <h2>Create a block</h2>

                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.block_name') }}" autocomplete="off" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.block_width') }}" autocomplete="off" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.block_height') }}" autocomplete="off" />
                            </div>
                            <!-- Height -->

                            <!-- Type -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_type') }}</label>
                                <select class="type form-control" autocomplete="off">
                                    <option value="">Choose a type</option>
                                    <option value="html">HTML</option>
                                    <option value="menu">Menu</option>
                                    <option value="view_file">View file</option>
                                </select>
                            </div>
                            <!-- Type -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.block_class') }}" autocomplete="off" />
                            </div>
                            <!-- Class-->

                            <input type="hidden" class="area_id" />

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" class="page-content-valid-create-block btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" class="page-content-close-create-block btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                            </div>
                            <!-- Save -->

                        </div>
                        <!-- CREATE BLOCK FORM -->


                        <!-- UPDATE BLOCK FORM -->
                        <div class="update-block-form">

                            <h2>Edit a block</h2>

                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.block_name') }}" autocomplete="off" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.block_width') }}" autocomplete="off" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.block_height') }}" autocomplete="off" />
                            </div>
                            <!-- Height -->

                            <!-- Type -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_type') }}</label>
                                <select class="type form-control" autocomplete="off">
                                    <option value="">Choose a type</option>
                                    <option value="html">HTML</option>
                                    <option value="menu">Menu</option>
                                    <option value="view_file">View file</option>
                                </select>
                            </div>
                            <!-- Type -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.block_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.block_class') }}" autocomplete="off" />
                            </div>
                            <!-- Class-->

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" class="page-content-update-block btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" class="page-content-close-update-block btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
                            </div>
                            <!-- Save -->

                        </div>
                        <!-- UPDATE BLOCK FORM -->

                        <!-- UPDATE AREA FORM -->
                        <div class="update-area-form">
                            <!-- Name -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_name') }}</label>
                                <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.area_name') }}" autocomplete="off" />
                            </div>
                            <!-- Name -->

                            <!-- Width -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_width') }}</label>
                                <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.area_width') }}" autocomplete="off" />
                            </div>
                            <!-- Width -->

                            <!-- Height -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_height') }}</label>
                                <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.area_height') }}" autocomplete="off" />
                            </div>
                            <!-- Height -->

                            <!-- Class -->
                            <div class="form-group">
                                <label>{{ trans('w-cms-laravel::pages.area_class') }}</label>
                                <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.area_class') }}" autocomplete="off" />
                            </div>
                            <!-- Class-->

                            <!-- Save -->
                            <div class="submit_wrapper">
                                <input type="button" class="page-content-update-area btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                                <input type="button" class="page-content-close-update-area btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
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