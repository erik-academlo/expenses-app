<x-mail::message>

Hello {{ $user->name }}.
Your excel file has been uploaded successfully.

<x-mail::button :url="env('APP_URL')">
View data
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
