<div class="form-group">
    <label>{{ trans('w-cms-laravel::blocks.media_block') }}</label>

    @include ('w-cms-laravel::back.editorial.includes.media_field', [
        'divID' => (isset($block)) ? 'block-' . $block->ID : 'block-media-id',
        'media' => (isset($block) && isset($block->content) && isset($block->content->media)) ? $block->content->media : null
    ])
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
    <input name="media_link" type="text" class="form-control media_link" placeholder="{{ trans('w-cms-laravel::pages.block_media_link') }}" value="@if (isset($block)){{ $block->mediaLink }}@endif" autocomplete="off" />
</div>