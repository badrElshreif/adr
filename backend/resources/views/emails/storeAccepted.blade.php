@component('mail::message')
    {{--{{trans('general.hello')}}--}}

 {{trans('general.accept_store')}}  {{$store_name}}

{{trans('general.login_data_is')}}: <br>

{{trans('trans-dashboard.url')}}: https://shoplo.fudex-tech.net/ar/companies/auth/login <br>
{{trans('trans-dashboard.email')}}: {{$email}} <br>
{{trans('trans-dashboard.password')}}:  {{$password}} <br>


{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

{{trans('general.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
