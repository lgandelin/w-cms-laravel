<div class="form-group">
    <label>{{ $label }}</label>
    <input name="{{ $name }}" type="text" class="form-control {{ $class }}" @if ($placeholder)placeholder="{{ $placeholder }}"@endif value="{{ $value }}" autocomplete="off" />
</div>