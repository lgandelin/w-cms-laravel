<!-- MEDIAS MODAL -->
<div class="modal fade" id="medias-modal" tabindex="-1" role="dialog" aria-labelledby="medias" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="area-infos">Medias</h4>
            </div>

            <div class="modal-body">
                @if (isset($medias))
                <ul style="overflow: hidden; display: block; padding-left: 10px">
                    @foreach ($medias as $media)
                    <li style="display: inline-block; padding-right: 20px; vertical-align: middle; text-align: center">
                        <a href="#" class="thumbnail popup-media-id" data-id="{{ $media->ID }}" data-name="{{ $media->name }}" data-src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}">
                            <img src="{{ asset(Shortcut::get_uploads_folder() . $media->ID . '/' . $media->fileName) }}" width="175" alt="{{ $media->name }}" />
                            <span class="media-name" style="font-weight: bold;">{{ $media->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div class="modal-footer">
                <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
            </div>
        </div>
    </div>
</div>
<!-- MEDIAS MODAL -->