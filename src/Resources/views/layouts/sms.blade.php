<x-admin::layouts>
    <x-slot:title>
        @yield('title') - @lang('seven::app.name')
    </x-slot>

    <x-admin::form
        :action="route('admin.seven.sms_submit')"
        enctype="multipart/form-data"
        method="POST"
    >
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">
            @yield('heading')
        </h1>

        @csrf()

        <input name='id' value='{{ $id ?? null }}' type='hidden'/>
        <input name='entityType' value='{{ $entityType }}' type='hidden'/>

        @yield('filters')

        @include('seven::sms.flash')
        @include('seven::sms.performance_tracking')
        @include('seven::sms.from')
        @include('seven::sms.text')

        <button type='submit' class='primary-button'>
            @lang('seven::app.send_sms')
        </button>
    </x-admin::form>
</x-admin::layouts>
