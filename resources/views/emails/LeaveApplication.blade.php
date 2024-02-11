@component('mail::message')
    <h1>Leave Application</h1>
    <h2>{{ $name }}</h2>
    <h2>{{ $date }}</h2>

    {{ $email }}
@endcomponent
