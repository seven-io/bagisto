@extends('admin::layouts.master')

@section('page_title')
    @yield('title') - @lang('seven::app.name')
@stop

@section('content-wrapper')
    <div class='content full-page'>
        <form method='POST' action='{{ route('admin.seven.sms_submit') }}'>
            <div class='page-header'>
                <div class='page-title'>
                    <h1>@yield('heading')</h1>
                </div>

                <div class='page-action'>
                    <button type='submit' class='btn btn-lg btn-primary'>
                        @lang('seven::app.send_sms')
                    </button>
                </div>
            </div>

            <div class='page-content'>
                <div class='form-container'>
                    @csrf()

                    <input name='id' value='{{ $id ?? null }}' type='hidden'/>
                    <input name='entityType' value='{{ $entityType }}' type='hidden'/>

                    @yield('filters')

                    <div class='control-group' :class='[errors.has(`flash`) ? `has-error` : ``]'>
                        <label for='flash'>
                            @lang('seven::app.flash')
                        </label>

                        <label class='switch'>
                            <input
                                    class='control'
                                    id='flash'
                                    name='flash'
                                    type='checkbox'
                                    {{ old('flash') ? 'checked' : '' }}
                            />

                            <span class='slider round'></span>
                        </label>
                    </div>

                    <div class='control-group'
                         :class='[errors.has(`performance_tracking`) ? `has-error` : ``]'>
                        <label for='performance_tracking'>
                            @lang('seven::app.performance_tracking')
                        </label>

                        <label class='switch'>
                            <input
                                    class='control'
                                    id='performance_tracking'
                                    name='performance_tracking'
                                    type='checkbox'
                                    {{ old('performance_tracking') ? 'checked' : '' }}
                            />

                            <span class='slider round'></span>
                        </label>
                    </div>

                    <div class='control-group'
                         :class='[errors.has(`debug`) ? `has-error` : ``]'>
                        <label for='debug'>
                            @lang('seven::app.debug')
                        </label>

                        <label class='switch'>
                            <input
                                class='control'
                                id='debug'
                                name='debug'
                                type='checkbox'
                                {{ old('debug') ? 'checked' : '' }}
                            />

                            <span class='slider round'></span>
                        </label>
                    </div>

                    <div class='control-group' :class='[errors.has(`from`) ? `has-error` : ``]'>
                        <label for='from'>
                            @lang('seven::app.from')
                        </label>

                        <input
                                class='control'
                                data-vv-as='&quot;@lang('seven::app.from')&quot;'
                                id='from'
                                name='from'
                                placeholder='Bagisto'
                                v-validate='{
                             max: 16,
                             regex: /^([+]?[0-9]{1,16}|[a-zA-Z0-9 \-_+/()&$!,.@]{1,11})$/
                            }'
                                value='{{ old('from') }}'
                        />

                        <span class='control-error' v-if='errors.has(`from`)'>
                        @{{ errors.first('from') }}
                    </span>
                    </div>

                    <div class='control-group' :class='[errors.has(`text`) ? `has-error` : ``]'>
                        <label for='text' class='required'>
                            @lang('seven::app.text')
                        </label>

                        <textarea
                                class='control'
                                data-vv-as='&quot;@lang('seven::app.text')&quot;'
                                id='text'
                                name='text'
                                placeholder='@lang('seven::app.text_placeholder')'
                                v-validate='`required|max:1520`'
                        >{{ old('text') }}</textarea>

                        <span class='control-error' v-if='errors.has(`text`)'>
                        @{{ errors.first('text') }}
                    </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
