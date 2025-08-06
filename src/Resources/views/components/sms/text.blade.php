<x-admin::form.control-group class="required">
    <x-admin::form.control-group.label>
        @lang('seven::app.text')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        name="text"
        rules="required"
        type="text"
        :label="trans('seven::app.text')"
        :placeholder="trans('seven::app.text_placeholder')"
    />

    <x-admin::form.control-group.error control-name="text" />
</x-admin::form.control-group>
