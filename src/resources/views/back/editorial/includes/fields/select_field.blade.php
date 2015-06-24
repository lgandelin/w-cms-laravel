<div class="form-group">
    <label>{{ $label }}</label>
    <select name="{{ $name }}" class="form-control {{ $class }}" autocomplete="off">
        <option value="">@if ($default_option_name){{ $default_option_name }}@else{{ trans('w-cms-laravel::generic.default_option_name') }}@endif</option>
        @if (isset($items))
            @foreach ($items as $item)
                <option value="{{ $item->ID }}" @if ($value == $item->ID) selected="selected" @endif>{{ $item->$item_property_name }}</option>
            @endforeach
        @endif
    </select>
</div>