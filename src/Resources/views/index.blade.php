@extends('seven::layouts.sms')

@section('title')
    @lang('seven::app.send_sms_bulk')
@stop

@section('heading')
    @lang('seven::app.send_sms_bulk')
@stop

@section('filters')
    <p>
        @lang('seven::app.about_bulk')
    </p>
    <v-seven-sms-bulk>
        <div class="flex cursor-pointer items-center justify-between gap-1.5 px-2.5 text-blue-600 transition-all hover:underline"></div>
    </v-seven-sms-bulk>
@stop

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
