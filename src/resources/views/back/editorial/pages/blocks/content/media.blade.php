<div class="form-group">
    <label>{{ trans('w-cms-laravel::blocks.media_block') }}</label>

    <div id="block-{{ $block->ID }}-media-id">
        <div class="thumbnail" style="width:200px; margin-bottom: 15px">
            <img style="max-width: 100%; display:block" src="@if (isset($block->content->media)){{ asset(Shortcut::get_uploads_folder() . $block->content->media->ID . '/' . $block->content->media->fileName) }} @endif" />
            <span class="media-name" style="margin-top: 5px; display: block;">@if (isset($block->content->media)){{ $block->content->media->name }}@endif</span>
        </div>
        <input name="media_id" class="media_id" type="hidden" value="{{ $block->media_id }}" />
    </div>
    <input type="button" class="btn btn-primary open-medias-modal" data-div-id="block-{{ $block->ID }}-media-id" value="{{ trans('w-cms-laravel::generic.browse') }}" />
</div>

<div class="form-group">
    <label for="media_format_id">{{ trans('w-cms-laravel::pages.block_media_format') }}</label>
    <select name="media_format_id" class="media_format_id form-control" autocomplete="off">
        <option value="">{{ trans('w-cms-laravel::pages.choose_media_format') }}</option>
        @if (isset($media_formats))
            @foreach ($media_formats as $media_format)
                <option value="{{ $media_format->ID }}" @if (isset($block->media_format_id) && $block->media_format_id == $media_format->ID) selected="selected" @endif>{{ $media_format->name }} ({{ $media_format->width }} x {{ $media_format->height}})</option>
            @endforeach
        @endif
    </select>
</div>

<div class="form-group">
    <label>{{ trans('w-cms-laravel::pages.block_media_link') }}</label>
    <input name="media_link" type="text" class="form-control media_link" placeholder="{{ trans('w-cms-laravel::pages.block_media_link') }}" value="{{ $block->media_link }}" autocomplete="off" />
</div>