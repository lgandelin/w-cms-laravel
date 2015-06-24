<div class="form-group">
    <label>{{ trans('w-cms-laravel::generic.content') }}</label>
    <textarea name="@if (isset($name) && $name != ''){{ $name }}@else{{ 'html' }}@endif" @if ($new)class="ckeditor"@endif id="{{ $divID }}">{{ $html }}</textarea>
</div>