@component('mail::message')

Selamat datang {{ $user->name }}

@component('mail::button', ['url' => url('/reset-password/'.$user->remember_token)])
Atur ulang password
@endcomponent

Silahkan klik tombol diatas untuk melakukan atur ulang password akun anda.<br>
{{ config('app.name') }}
@endcomponent