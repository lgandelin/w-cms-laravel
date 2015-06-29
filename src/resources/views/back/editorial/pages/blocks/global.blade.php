@include ('w-cms-laravel::back.editorial.includes.fields.select_field', [
    'label' => trans('w-cms-laravel::pages.global_block'),
    'name' => 'block_reference_id',
    'class' => 'block_reference_id',
    'default_option_name' => trans('w-cms-laravel::pages.choose_global_block'),
    'items' => $global_blocks,
    'value' => (isset($block->blockReferenceID)) ? $block->blockReferenceID : null,
    'item_property_name' => 'name'
])