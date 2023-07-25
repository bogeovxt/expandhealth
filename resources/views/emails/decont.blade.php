<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="$url">
View Order
</x-mail::button>


<x-mail::table>
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|

| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
