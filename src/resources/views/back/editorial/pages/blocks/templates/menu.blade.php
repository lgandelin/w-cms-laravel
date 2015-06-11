<div id="block-template-menu">
    <div class="form-group">
        <label>{{ trans('w-cms-laravel::pages.block_menu') }}</label>
        <select name="menu_id" class="menu_id form-control" autocomplete="off">
            <option value="">{{ trans('w-cms-laravel::pages.choose_menu') }}</option>
            @if (isset($menus))
                @foreach ($menus as $menu)
                    <option value="{{ $menu->ID }}">{{ $menu->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>