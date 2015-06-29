@include ('w-cms-laravel::back.editorial.includes.fields.editor_field', [
    'divID' => (isset($block)) ? 'editor-' . $block->ID : 'editor-new-field',
    'html' => (isset($block)) ? $block->html : '',
    'new' => (isset($block) && $block->ID) ? true : false,
    'name' => 'html'
])