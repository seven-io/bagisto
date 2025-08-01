<x-admin::form.control-group>
    <x-admin::form.control-group.label>@lang('seven::app.from')</x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        name="from"
        rules="max:16"
        type="text"
        :label="trans('seven::app.from')"
        placeholder="Bagisto"
    />

    <x-admin::form.control-group.error control-name="from" />
</x-admin::form.control-group>
