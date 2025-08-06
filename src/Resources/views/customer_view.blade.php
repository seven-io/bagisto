<div class="box-shadow rounded bg-white p-4 last:pb-0 dark:bg-gray-900">
    <p class="p-4 pb-0 text-base font-semibold leading-none text-gray-800 dark:text-white">
        @lang('seven::app.send_sms')
    </p>

    <x-admin::form
        :action="route('admin.seven.sms_submit')"
        enctype="multipart/form-data"
        method="POST"
    >
        <x-sms-from value=''></x-sms-from>
        <x-sms-text></x-sms-text>

        <button type='submit' class='primary-button'>@lang('seven::app.send_sms')</button>
    </x-admin::form>
</div>
