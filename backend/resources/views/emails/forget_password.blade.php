@component('mail::message')
    {{ $message }}

    {{-- @component('mail::button', ['url' => ''])

@endcomponent --}}

    {{ trans('general.thanks') }},<br>
    {{ config('app.name') }}
@endcomponent
