@component('mail::message')
# Introduction

Your verification code for TimeZone application is {{ $user->remeber_token }}, kindly use the code to login then you may change your password.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
