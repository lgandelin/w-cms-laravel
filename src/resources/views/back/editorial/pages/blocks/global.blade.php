<div class="form-group">
    <label>{{ trans('w-cms-laravel::blocks.global_block') }}</label>
    <select class="block_reference_id form-control" autocomplete="off">
        <option value="">{{ trans('w-cms-laravel::pages.choose_global_block') }}</option>
        @if (isset($global_blocks))
            @foreach ($global_blocks as $global_block)
                <option value="{{ $global_block->ID }}" @if (isset($block->block_reference_id) && $block->block_reference_id == $global_block->ID) selected="selected" @endif>{{ $global_block->name }}</option>
            @endforeach
        @endif
    </select>
</div>