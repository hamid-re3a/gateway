@component('mail::message')
    Dear
 **{{ $user->name }}**,

    Your ticket is answered
@component('mail::panel')
     ** Ticket id {{ $ticket_id }}**
@endcomponent
    Thank you
{{ config('app.name') }}
@endcomponent
