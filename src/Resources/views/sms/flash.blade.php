<x-admin::form.control-group>
    <x-admin::form.control-group.label>
        @lang('seven::app.flash')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="switch"
        name="flash"
        :value="1"
        :label="trans('seven::app.flash')"
    />

    <x-admin::form.control-group.error control-name="flash" />
</x-admin::form.control-group>
