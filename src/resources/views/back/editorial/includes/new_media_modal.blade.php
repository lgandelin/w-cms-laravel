<!-- IFRAME MODAL -->
<div class="modal fade" id="new-media-modal" tabindex="-1" role="dialog" aria-labelledby="medias" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="area-infos">New media</h4>
            </div>

            <div class="modal-body">
                <div class="modal-body">
                    {!! Form::open(array('url' => route('back_medias_update'), 'method' => 'post', 'class' => 'row', 'enctype' => 'multipart/form-data')) !!}

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">{{ trans('w-cms-laravel::medias.name') }}</label>
                            <input autocomplete="off" type="text" class="form-control media-name" id="name" name="name" placeholder="{{ trans('w-cms-laravel::medias.name') }}" value="" />
                        </div>

                        <div class="form-group">
                            <label for="alt">{{ trans('w-cms-laravel::medias.alt') }}</label>
                            <input autocomplete="off" type="text" class="form-control media-alt" id="alt" name="alt" placeholder="{{ trans('w-cms-laravel::medias.alt') }}" value="" />
                        </div>

                        <div class="form-group">
                            <label for="title">{{ trans('w-cms-laravel::medias.title') }}</label>
                            <input autocomplete="off" type="text" class="form-control media-title" id="title" name="title" placeholder="{{ trans('w-cms-laravel::medias.title') }}" value="" />
                        </div>

                        <input type="hidden" name="ID" value="" />
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">{{ trans('w-cms-laravel::medias.thumbnail') }}</label>
                            <div class="media-thumbnail thumbnail" style="width:200px; display: none">
                                <img />
                            </div>
                        <span class="btn  btn-primary btn-file">
                            {{ trans('w-cms-laravel::generic.browse') }} <input type="file" name="image">
                        </span>
                        </div>
                    </div>

                    <input type="hidden" class="new-media-id" />

                    {!! Form::close() !!}
                </div>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
            </div>
        </div>
    </div>
</div>
<!-- IFRAME MODAL -->