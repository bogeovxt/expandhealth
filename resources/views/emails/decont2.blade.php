@component('mail::message')
Buna  {{ $maildata['title'] }},

In perioada {{ $maildata['period'] }} ai avut urmatoarele tranzactii cu cardul ING:

@component('mail::table')
| DATA       | DEBIT          | CREDIT         | DESCRIERE      |
| :--------- | :------------- | :------------- | :------------- |
@foreach ( $maildata['rows'] as $row)
| {{$row['date']}} | {{$row['debit']}} | {{$row['credit']}} | {{$row['descriere']}} |
@endforeach
@endcomponent

{{ config('app.name') }}
@endcomponent
