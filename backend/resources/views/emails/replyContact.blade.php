@component('mail::message')
# {{trans('general.replying_to_message')}} ( {{$contact->parent->title??substr($contact->parent->body,0,50)}} )

{!! $contact->body !!}


{{trans('general.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
