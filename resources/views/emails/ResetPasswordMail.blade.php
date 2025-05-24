@component('mail::message')
# Welcome, {{ $name }} 👋

<h1>You have requested to reset your password. Please click the button below to set a new password for your account.</h1>
<h2>Here Your Code: {{ $code }}</h2>

@component('mail::button', ['url' => 'https://your-app.com/login'])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
