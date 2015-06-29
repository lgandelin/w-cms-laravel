@include ('w-cms-laravel::back.editorial.includes.fields.text_field', [
    'label' => trans('w-cms-laravel::pages.block_view_file'),
    'name' => 'view_path',
    'class' => 'view_path',
    'placeholder' => trans('w-cms-laravel::pages.block_view_file'),
    'value' => (isset($block)) ? $block->viewPath : ''
])