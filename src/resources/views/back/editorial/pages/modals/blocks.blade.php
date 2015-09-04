<div class="modal fade" id="block-infos-modal" tabindex="-1" role="dialog" aria-labelledby="block-infos" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="area-infos">Block infos</h4>
            </div>

            <div class="modal-body">

                <!-- Name -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_name') }}</label>
                    <input type="text" class="form-control name" placeholder="{{ trans('w-cms-laravel::pages.block_name') }}" autocomplete="off" />
                </div>
                <!-- Name -->

                <!-- Width -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_width') }}</label>
                    <input type="text" class="form-control width" placeholder="{{ trans('w-cms-laravel::pages.block_width') }}" autocomplete="off" />
                </div>
                <!-- Width -->

                <!-- Height -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_height') }}</label>
                    <input type="text" class="form-control height" placeholder="{{ trans('w-cms-laravel::pages.block_height') }}" autocomplete="off" />
                </div>
                <!-- Height -->

                <!-- Type -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_type') }}</label>
                    <select class="type form-control" autocomplete="off">
                        <option value="">{{ trans('w-cms-laravel::blocks.choose_block_type') }}</option>
                        @foreach ($block_types as $blockType)
                        <option value="{{ $blockType->code }}">{{ $blockType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Type -->

                <!-- Class -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_class') }}</label>
                    <input type="text" class="form-control class" placeholder="{{ trans('w-cms-laravel::pages.block_class') }}" autocomplete="off" />
                </div>
                <!-- Class-->

                <!-- Alignment -->
                <div class="form-group">
                    <label>{{ trans('w-cms-laravel::pages.block_alignment') }}</label>
                    <span class="radio-text" style="display: inline-block">{{ trans('w-cms-laravel::generic.left') }}</span> <input type="radio" id="block_alignment_left" name="block_alignment" value="left" autocomplete="off" checked />
                    <span class="radio-text" style="margin-left: 10px; display: inline-block">{{ trans('w-cms-laravel::generic.center') }}</span> <input type="radio" id="block_alignment_center" name="block_alignment" value="center" autocomplete="off" />
                    <span class="radio-text" style="margin-left: 10px; display: inline-block">{{ trans('w-cms-laravel::generic.right') }}</span> <input type="radio" id="block_alignment_right" name="block_alignment" value="right" autocomplete="off" />
                </div>
                <!-- Alignment-->

                <!-- Is master -->
                {{--<div class="form-group">
                <label for="is_master">{{ trans('w-cms-laravel::pages.is_master') }}</label>
                <br/>
                Non <input type="radio" id="block_is_master_0" name="block_is_master" value="0" autocomplete="off" />
                Oui <input type="radio" id="block_is_master_1" name="block_is_master" value="1" autocomplete="off" />
            </div>
                <!-- Is master -->

                <!-- Is ghost -->
                <div class="form-group">
                    <label for="is_ghost">{{ trans('w-cms-laravel::pages.is_ghost') }}</label>
                    <br/>
                    Non <input type="radio" id="block_is_ghost_0" name="block_is_ghost" value="0" autocomplete="off" />
                    Oui <input type="radio" id="block_is_ghost_1" name="block_is_ghost" value="1" autocomplete="off" />
                </div>--}}
                <!-- Is ghost -->

                <input type="hidden" class="area_id" />
            </div>

            <div class="modal-footer">
                <input type="button" class="btn-valid btn btn-success" value="{{ trans('w-cms-laravel::generic.submit') }}" />
                <input type="button" class="btn-close btn btn-default" data-dismiss="modal" value="{{ trans('w-cms-laravel::generic.close') }}" />
            </div>
        </div>
    </div>
</div>