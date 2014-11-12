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

    <!-- Create area -->
    <div class="form-group">
        <input type="button" data-id="{{ $page->ID }}" class="page-content-create-area btn btn-success" value="{{ trans('w-cms-laravel::pages.add_area') }}" />
        <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
    </div>
    <!-- Create area -->

    <!-- AREA FORM -->
    <div class="area-form">

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
            <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <input type="button" class="btn-close btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
        </div>
        <!-- Save -->

        <input type="hidden" class="page-id" value="{{ $page->ID }}" />

    </div>
    <!-- AREA FORM -->



    <!-- BLOCK FORM -->
    <div class="block-form">

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
                <option value="article">Article</option>
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
            <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
            <input type="button" class="btn-close btn btn-default" value="{{ trans('w-cms-laravel::generic.close') }}" />
        </div>
        <!-- Save -->

    </div>
    <!-- BLOCK FORM -->

</div>
<!-- STRUCTURE -->
 