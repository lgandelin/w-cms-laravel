@include ('w-cms-laravel::back.editorial.includes.fields.select_field', [
    'label' => trans('w-cms-laravel::pages.block_menu'),
    'name' => 'menu_id',
    'class' => 'menu_id',
    'default_option_name' => trans('w-cms-laravel::pages.choose_menu'),
    'items' => isset($menus) ? $menus : null,
    'value' => (isset($block->menuID)) ? $block->menuID : null,
    'item_property_name' => 'name'
])