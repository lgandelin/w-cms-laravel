@include ('w-cms-laravel::back.editorial.includes.fields.text_field', [
    'label' => trans('w-cms-laravel::pages.block_controller_class_path'),
    'name' => 'class_path',
    'class' => 'class_path',
    'placeholder' => trans('w-cms-laravel::pages.block_controller_class_path'),
    'value' => (isset($block)) ? $block->classPath : ''
])

@include ('w-cms-laravel::back.editorial.includes.fields.text_field', [
    'label' => trans('w-cms-laravel::pages.block_controller_method'),
    'name' => 'method',
    'class' => 'method',
    'placeholder' => trans('w-cms-laravel::pages.block_controller_method'),
    'value' => (isset($block)) ? $block->method : ''
])