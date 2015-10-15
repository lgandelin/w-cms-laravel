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

    <!-- Is visible -->
    <div class="form-group">
        <label for="meta_robots">{{ trans('w-cms-laravel::pages.is_visible') }}</label>
        {{ trans('w-cms-laravel::generic.yes') }} <input type="radio" name="is_visible" @if ($page->is_visible == "" || $page->is_visible === true)checked="checked"@endif autocomplete="off" value="true">&nbsp;&nbsp;
        {{ trans('w-cms-laravel::generic.no') }} <input type="radio" name="is_visible" @if ($page->is_visible === false)checked="checked"@endif autocomplete="off" value="false">
    </div>
    <!-- Is visible -->

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
                <div class="block @if (isset($block->masterBlockID) && $block->masterBlockID) child-block @endif" data-id="{{ $block->ID }}" data-type="{{ $block->type->code }}">
                    <span class="title">
                        <span class="block_name">{{ $block->name }}</span>
                        <span class="type">{{ $block->type->code }}</span>
                        @if ($block->masterBlockID)
                            <span class="glyphicon glyphicon-exclamation-sign disabled"></span>
                        @else
                            <span class="glyphicon glyphicon-chevron-down opening-status"></span>
                        @endif
                    </span>
                    <div class="content">
                        @if (isset($block->back_content))
                            {!! $block->back_content !!}
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
    <!--<input type="button" class="btn-publish btn btn-success pull-right" value="{{ trans('w-cms-laravel::generic.publish') }}" data-page-uri="{{ $page->uri }}" />-->

    <p>
        <strong>Version number : </strong> <span class="badge">{{ $page->version_number }}</span><br/>
        <strong>Draft version number : </strong> <span class="badge">{{ $page->draft_version_number }}</span>
    </p>
</div>
<!-- CONTENT -->

@include ('w-cms-laravel::back.editorial.includes.modals.media_modal')
@include ('w-cms-laravel::back.editorial.includes.modals.new_media_modal')