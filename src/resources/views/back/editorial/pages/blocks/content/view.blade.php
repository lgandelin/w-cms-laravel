<div class="form-group">
    <label>{{ trans('w-cms-laravel::pages.block_view_file') }}</label>
    <input name="view_path" type="text" class="form-control view_path" placeholder="{{ trans('w-cms-laravel::pages.view_file') }}" value="@if (isset($block)){{ $block->viewPath }}@endif" autocomplete="off" />
</div>