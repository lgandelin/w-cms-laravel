<div class="modal fade" id="area-infos-modal" tabindex="-1" role="dialog" aria-labelledby="area-infos" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="area-infos">Area infos</h4>
            </div>

            <div class="modal-body">

                <!-- Name -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.area_name') }}</label>
                    <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.area_name') }}" autocomplete="off" />
                </div>
                <!-- Name -->

                <!-- Width -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.area_width') }}</label>
                    <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.area_width') }}" autocomplete="off" />
                </div>
                <!-- Width -->

                <!-- Height -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.area_height') }}</label>
                    <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.area_height') }}" autocomplete="off" />
                </div>
                <!-- Height -->

                <!-- Class -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.area_class') }}</label>
                    <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.area_class') }}" autocomplete="off" />
                </div>
                <!-- Class-->

                <!-- Is master -->
                {{--<div class="form-group">
                    <label for="is_master">{{ trans('w-cms-laravel::pages.is_master') }}</label>
                    <br/>
                    Non <input type="radio" id="area_is_master_0" name="area_is_master" value="0" autocomplete="off" />
                    Oui <input type="radio" id="area_is_master_1" name="area_is_master" value="1" autocomplete="off" />
                </div>--}}
                <!-- Is master -->

                <input type="hidden" class="page-id" value="{{ $page->ID }}" />
            </div>

            <div class="modal-footer">
                <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
            </div>
        </div>
    </div>
</div>