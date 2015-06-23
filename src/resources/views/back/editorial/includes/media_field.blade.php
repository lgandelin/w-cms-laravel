<div id="{{ $divID }}-media-id">
    <div class="thumbnail" style="width:200px; margin-bottom: 15px">
        <img style="max-width: 100%; display:block" @if (isset($media))src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}"@endif />
        <span class="media-name" style="margin-top: 5px; display: block;">
            @if (isset($media))
                <a target="_blank" title="{{ trans('w-cms-laravel::generic.edit') }}" href="{{ route('back_medias_edit', ['id' => $media->ID]) }}">{{ $media->name }}</a>
            @else
                Pas de média associé
            @endif
        </span>
    </div>
    <input name="mediaID" class="media_id" type="hidden" value="@if (isset($media->ID)){{ $media->ID }}@endif" />
</div>

<input type="button" class="btn btn-primary open-medias-modal" data-div-id="{{ $divID }}-media-id" value="{{ trans('w-cms-laravel::generic.browse') }}" />
<input type="button" class="btn btn-danger delete-media" data-div-id="{{ $divID }}-media-id" value="{{ trans('w-cms-laravel::generic.delete') }}" />
