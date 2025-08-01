<x-admin::form.control-group>
    <x-admin::form.control-group.label>
        @lang('seven::app.performance_tracking')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="switch"
        name="performance_tracking"
        :value="1"
        :label="trans('seven::app.performance_tracking')"
    />

    <x-admin::form.control-group.error control-name="performance_tracking" />
</x-admin::form.control-group>
