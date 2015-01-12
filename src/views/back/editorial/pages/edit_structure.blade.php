<!-- STRUCTURE -->
<div class="tab-pane" id="structure">

    <p><strong>{{ trans('w-cms-laravel::pages.structure') }}</strong></p>

    <div class="row areas-wrapper">
        @if (isset($page->areas))
        @foreach ($page->areas as $area)
        <div id="a-{{ $area->ID }}" data-id="{{ $area->ID }}" class="area col-xs-{{ $area->width }}" data-width="{{ $area->width }}" data-display="{{ $area->display }}">
            <div class="area_color @if ($area->master_area_id) child-area @endif">
                <span class="title">
                    <span class="area-name">{{ $area->name }}</span> <span class="area_width">[<span class="width_value">{{ $area->width }}</span>]</span>
                    @if (!$area->master_area_id)
                        <span data-id="{{ $area->ID }}" class="area-delete glyphicon glyphicon-remove"></span>
                        <span data-id="{{ $area->ID }}" class="area-move glyphicon glyphicon-move"></span>
                        <span data-id="{{ $area->ID }}" class="area-display @if ($area->display == 0) area-hidden @endif glyphicon glyphicon-eye-open"></span>
                        <span data-id="{{ $area->ID }}" class="area-update glyphicon glyphicon-pencil"></span>
                        <span data-id="{{ $area->ID }}" class="area-create-block glyphicon glyphicon-plus"></span>
                    @else
                        <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                    @endif
                </span>

                @foreach ($area->blocks as $block)
                <div id="b-{{ $block->ID }}" data-id="{{ $block->ID }}" class="block col-xs-{{ $block->width}}" data-width="{{ $block->width }}" data-display="{{ $block->display }}">
                    <div class="block_color @if ($block->master_block_id) child-block @endif">
                        <span class="title">
                            <span class="block-name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span> [<span class="width_value">{{ $block->width }}</span>]
                            @if (!$block->master_block_id)
                                <span data-id="{{ $block->ID }}" class="block-delete glyphicon glyphicon-remove"></span>
                                <span data-id="{{ $block->ID }}" class="block-move glyphicon glyphicon-move"></span>
                                <span data-id="{{ $block->ID }}" class="block-display @if (!$block->display) block-hidden @endif glyphicon glyphicon-eye-open"></span>
                                <span data-id="{{ $block->ID }}" class="block-update glyphicon glyphicon-pencil"></span>
                            @else
                                <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                            @endif
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

    <!-- AREA INFOS MODAL-->
    <div class="modal fade" id="area-infos-modal" tabindex="-1" role="dialog" aria-labelledby="area-infos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="area-infos">Area infos</h4>
                </div>

                <div class="modal-body">

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

                    <input type="hidden" class="page-id" value="{{ $page->ID }}" />
                </div>

                <div class="modal-footer">
                    <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                    <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
                </div>
            </div>
        </div>
    </div>
    <!-- AREA INFOS MODAL -->



    <!-- BLOCK FORM -->
    <div class="modal fade" id="block-infos-modal" tabindex="-1" role="dialog" aria-labelledby="block-infos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="area-infos">Block infos</h4>
                </div>

                <div class="modal-body">

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
                            <option value="">{{ trans('w-cms-laravel::blocks.choose_block_type') }}</option>
                            <option value="html">{{ trans('w-cms-laravel::blocks.html_block') }}</option>
                            <option value="menu">{{ trans('w-cms-laravel::blocks.navigation_block') }}</option>
                            <option value="view_file">{{ trans('w-cms-laravel::blocks.view_block') }}</option>
                            <option value="article">{{ trans('w-cms-laravel::blocks.article_block') }}</option>
                            <option value="article_list">{{ trans('w-cms-laravel::blocks.article_list_block') }}</option>
                            <option value="global">{{ trans('w-cms-laravel::blocks.global_block') }}</option>
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
                </div>

                <div class="modal-footer">
                    <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                    <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
                </div>
            </div>
        </div>

    </div>
    <!-- BLOCK FORM -->

</div>
<!-- STRUCTURE -->
 