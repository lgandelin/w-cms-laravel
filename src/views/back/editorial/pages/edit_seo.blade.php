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