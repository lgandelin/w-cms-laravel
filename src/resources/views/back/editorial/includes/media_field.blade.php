<div id="block-{{ $block->ID }}-media-id">
    <div class="thumbnail" style="width:200px; margin-bottom: 15px">
        <img style="max-width: 100%; display:block" @if (isset($block->content->media))src="{{ asset(Shortcut::get_uploads_folder() . $block->content->media->ID . '/' . $block->content->media->fileName) }}"@endif />
        <span class="media-name" style="margin-top: 5px; display: block;">
            @if (isset($block->content->media))
                <a target="_blank" title="{{ trans('w-cms-laravel::generic.edit') }}" href="{{ route('back_medias_edit', ['id' => $block->mediaID]) }}">{{ $block->content->media->name }}</a>
            @else
                Pas de média associé
            @endif
        </span>
    </div>
    <input name="mediaID" class="media_id" type="hidden" value="@if (isset($block->mediaID)){{ $block->mediaID }}@endif" />
</div>

<input type="button" class="btn btn-primary open-medias-modal" data-div-id="block-{{ $block->ID }}-media-id" value="{{ trans('w-cms-laravel::generic.browse') }}" />
<input type="button" class="btn btn-danger delete-media" data-div-id="block-{{ $block->ID }}-media-id" value="{{ trans('w-cms-laravel::generic.delete') }}" />
