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

    <!-- Is master
    <div class="form-group">
        <label for="is_master">{{ trans('w-cms-laravel::pages.master_page') }}</label>
        <br/>
        Non <input type="radio" name="is_master" value="0" @if(!$page->is_master) checked @endif autocomplete="off" />
        Oui <input type="radio" name="is_master" value="1" @if($page->is_master) checked @endif autocomplete="off" />
    </div>
    <!-- Is master -->

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
        <div class="area @if ($area->masterAreaID) child-area @endif" data-id="{{ $area->ID }}">
            <span class="title">
                <span class="area_name">{{ $area->name }}</span>

                @if ($area->masterAreaID)
                    <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                @else
                    <span class="glyphicon glyphicon-chevron-up opening-status"></span>
                @endif
            </span>

            <div class="content">
                @foreach ($area->blocks as $block)
                <div class="block @if ($block->master_block_id) child-block @endif" data-id="{{ $block->ID }}" data-type="{{ $block->type }}">
                    <span class="title">
                        <span class="block_name">{{ $block->name }}</span> <span class="type">({{ $block->type }})</span>
                        @if ($block->master_block_id)
                            <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                        @else
                            <span class="glyphicon glyphicon-chevron-down opening-status"></span>
                        @endif
                    </span>
                    <div class="content">
                        @if (BlockType::getContentView($block->type))
                            @include (BlockType::getContentView($block->type))
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

@include ('w-cms-laravel::back.editorial.includes.media_modal')