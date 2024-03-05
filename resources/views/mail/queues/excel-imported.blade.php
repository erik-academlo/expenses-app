<x-mail::message>

Hola {{ $user->name }}.
Tu archivo ha sido importado correctamente.

Enseguida tienes un resumen de tus datos importados: <br>
@foreach($categoryCounts as $category => $count)
    {{ $category }}: {{ $count }} <br>
@endforeach

Puedes ver la información completa dando clic en el siguiente botón.
<x-mail::button :url="env('APP_URL')">
View data
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
