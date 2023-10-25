@component('mail::message')
    {{-- # {{trans('general.hello')}}, --}}

    {{ trans('general.reject_store') }} {{ $store_name }} <br>
    {{ $reason }}

    {{-- @component('mail::button', ['url' => ''])

@endcomponent --}}

    {{ trans('general.thanks') }},<br>
    {{ config('app.name') }}
@endcomponent
