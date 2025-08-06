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

        <x-seven-sms-flash></x-seven-sms-flash>
        <x-seven-sms-performance-tracking></x-seven-sms-performance-tracking>
        <x-seven-sms-from value='{{ $from }}'></x-seven-sms-from>
        <x-seven-sms-text></x-seven-sms-text>

        <button type='submit' class='primary-button'>@lang('seven::app.send_sms')</button>
    </x-admin::form>
</x-admin::layouts>
