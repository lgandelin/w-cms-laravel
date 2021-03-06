<div class="tab-pane" id="structure">

    <p><strong>{{ trans('w-cms-laravel::pages.structure') }}</strong></p>

    <div class="row areas-wrapper">
        <div class="update-in-progress" style="display: none"></div>
        @if (isset($page->areas))
            @foreach ($page->areas as $area)
                <div id="a-{{ $area->ID }}" data-id="{{ $area->ID }}" class="area col-xs-{{ $area->width }}" data-width="{{ $area->width }}" data-display="{{ $area->display }}">
                    <div class="area_color @if ($area->masterAreaID) child-area @endif">
                        <span class="title">
                            <span class="width_value">{{ $area->width }}</span>
                            <span class="area-name">{{ $area->name }}</span>
                            @if (!$area->masterAreaID)
                                <span data-id="{{ $area->ID }}" class="area-delete glyphicon glyphicon-remove"></span>
                                <span style="display: none" data-id="{{ $area->ID }}" class="area-move glyphicon glyphicon-move"></span>
                                <span data-id="{{ $area->ID }}" class="area-display @if ($area->display == 0) area-hidden @endif glyphicon glyphicon-eye-open"></span>
                                <span data-id="{{ $area->ID }}" class="area-update glyphicon glyphicon-cog"></span>
                                <span data-id="{{ $area->ID }}" class="area-create-block glyphicon glyphicon-plus"></span>
                            @else
                                <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                            @endif
                        </span>

                        @foreach ($area->blocks as $block)
                            <div id="b-{{ $block->ID }}" data-id="{{ $block->ID }}" class="block col-xs-{{ $block->width}} align-{{ $block->alignment }}" data-width="{{ $block->width }}" data-display="{{ $block->display }}">
                                <div class="block_color @if ($block->masterBlockID) child-block @endif">
                                    <span class="title">
                                        <span class="width_value">{{ $block->width }}</span>
                                        <span class="block-name">{{ $block->name }}</span>
                                        <span class="type">{{ $block->type->code }}</span>
                                        @if (!$block->masterBlockID)
                                            <span data-id="{{ $block->ID }}" class="block-delete glyphicon glyphicon-remove"></span>
                                            <span style="display: none" data-id="{{ $block->ID }}" class="block-move glyphicon glyphicon-move"></span>
                                            <span data-id="{{ $block->ID }}" class="block-display @if (!$block->display) block-hidden @endif glyphicon glyphicon-eye-open"></span>
                                            <span data-id="{{ $block->ID }}" class="block-update glyphicon glyphicon-cog"></span>
                                            <span data-id="{{ $block->ID }}" class="block-go-to-content glyphicon glyphicon-pencil"></span>
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

    <p>
        <strong>Version number : </strong> <span class="badge">{{ $current_version->number }}</span><br/>
        <strong>Draft version number : </strong> <span class="badge">{{ $draft_version->number }}</span>
    </p>

    <!-- Create area -->
    <div class="form-group">
        <input type="button" data-id="{{ $page->ID }}" class="page-content-create-area btn btn-success" value="{{ trans('w-cms-laravel::pages.add_area') }}" />
        <a class="btn btn-default" href="{{ route('back_pages_index') }}" title="{{ trans('w-cms-laravel::header.pages') }}">{{ trans('w-cms-laravel::generic.cancel') }}</a>
        <!--<input type="button" class="btn-publish btn btn-success pull-right" value="{{ trans('w-cms-laravel::generic.publish') }}" data-page-uri="{{ $page->uri }}" />-->
    </div>
    <!-- Create area -->

    @include('w-cms-laravel::back.editorial.pages.modals.areas')
    @include('w-cms-laravel::back.editorial.pages.modals.blocks')
</div>

<script id="area-structure-template" type="text/x-handlebars-template">
    <div id="a-@{{ ID }}" data-id="@{{ ID }}" class="area col-xs-@{{ width }}" data-width="@{{ width }}" data-display="@{{ display }}">
        <div class="area_color @{{#if masterAreaID}} child-area @{{/if}}">
            <span class="title">
                <span class="width_value">@{{ width }}</span>
                <span class="area-name">@{{ name }}</span>
                <span data-id="@{{ ID }}" class="area-delete glyphicon glyphicon-remove"></span>
                <span style="display: none" data-id="@{{ ID }}" class="area-move glyphicon glyphicon-move"></span>
                <span data-id="@{{ ID }}" class="area-display glyphicon glyphicon-eye-open @{{#if hidden}} area-hidden @{{/if}}"></span>
                <span data-id="@{{ ID }}" class="area-update glyphicon glyphicon-cog"></span>
                <span data-id="@{{ ID }}" class="area-create-block glyphicon glyphicon-plus"></span>
            </span>
        </div>
    </div>
</script>

<script id="block-structure-template" type="text/x-handlebars-template">
    <div id="b-@{{ ID }}" data-id="@{{ ID }}" class="block col-xs-@{{ width }} align-@{{ alignment }}" data-width="@{{ width }}" data-display="@{{ display }}">
        <div class="block_color @{{#if masterBlockID}} child-block @{{/if}}">
            <span class="title">
                <span class="width_value">@{{ width }}</span>
                <span class="block-name">@{{ name }}</span>
                <span class="type">@{{ type.code }}</span>
                <span data-id="@{{ ID }}" class="block-delete glyphicon glyphicon-remove"></span>
                <span style="display: none" data-id="@{{ ID }}" class="block-move glyphicon glyphicon-move"></span>
                <span data-id="@{{ ID }}" class="block-display glyphicon glyphicon-eye-open @{{#if hidden}} block-hidden @{{/if}}"></span>
                <span data-id="@{{ ID }}" class="block-update glyphicon glyphicon-cog"></span>
                <span data-id="@{{ ID }}" class="block-go-to-content glyphicon glyphicon-pencil"></span>
            </span>
        </div>
    </div>
</script>