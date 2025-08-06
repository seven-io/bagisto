<x-admin::form.control-group>
    <x-admin::form.control-group.label>@lang('seven::app.from')</x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        name="from"
        placeholder="Bagisto"
        rules="max:16"
        type="text"
        value='{{ $value }}'
        :label="trans('seven::app.from')"
    />

    <x-admin::form.control-group.error control-name="from" />
</x-admin::form.control-group>
