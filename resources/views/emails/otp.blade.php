@component('mail::message')
    Dear **{{ $user->first_name . ' ' . $user->last_name }}**,

@component('mail::panel')
     Your OTP is {{$token}}
@endcomponent
    Good luck
@endcomponent
