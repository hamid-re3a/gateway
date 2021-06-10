@component('mail::message')
    Dear **{{ $user->first_name . ' ' . $user->last_name }}**,
    Welcome to Ride To Future
@component('mail::panel')
     ** We are happy to have you **
@endcomponent
    Thank you {{ config('app.name') }}
@endcomponent
