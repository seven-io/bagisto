<x-admin::layouts>
    <x-slot:title>
        @lang('seven::app.send_sms_bulk') - @lang('seven::app.name')
    </x-slot>

    <x-admin::form
        :action="route('admin.seven.sms_submit_bulk')"
        enctype="multipart/form-data"
        method="POST"
    >
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">@lang('seven::app.send_sms_bulk')</h1>

        @csrf()

        <p>@lang('seven::app.about_bulk')</p>

        <x-seven-customer-groups></x-seven-customer-groups>

        <x-sms-flash></x-sms-flash>
        <x-sms-performance-tracking></x-sms-performance-tracking>
        <x-sms-from value='{{ $from }}'></x-sms-from>
        <x-sms-text></x-sms-text>

        <button type='submit' class='primary-button'>@lang('seven::app.send_sms')</button>
    </x-admin::form>
</x-admin::layouts>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-seven-sms-bulk-template"
    >
        <x-admin::form.control-group class="w-full">
            <x-admin::form.control-group.label>
                @lang('admin::app.customers.customers.view.edit.customer-group')
            </x-admin::form.control-group.label>

            <x-admin::form.control-group.control
                type="select"
                name="customerGroupId"
                id="customerGroup"
                :label="trans('admin::app.customers.customers.view.edit.customer-group')"
            >
                <option
                    v-for="customerGroup in customerGroups"
                    :value="customerGroup.id"
                >
                    @{{ customerGroup.name }}
                </option>
            </x-admin::form.control-group.control>
        </x-admin::form.control-group>
    </script>
    <script type="module">
        app.component('v-seven-sms-bulk', {
            template: '#v-seven-sms-bulk-template',
            data() {
                return {
                    customerGroups: @json($customerGroups),
                };
            },
            methods: {}
        })
    </script>
@endPushOnce
