<x-admin::form.control-group class="w-full">
    <x-admin::form.control-group.label>
        @lang('admin::app.customers.customers.view.edit.customer-group')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        label="@lang('admin::app.customers.customers.view.edit.customer-group')"
        name="customerGroupId"
        type="select"
    >
        @foreach ($customerGroups as $customerGroup)
            <option value="{{  $customerGroup->id }}">
                {{ $customerGroup->name }}
            </option>
        @endforeach
    </x-admin::form.control-group.control>
</x-admin::form.control-group>
