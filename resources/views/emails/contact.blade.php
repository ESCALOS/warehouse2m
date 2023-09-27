<x-mail::message>
# Nuevo Mensaje de Contacto

## **Mensaje:**

<x-mail::button :url="env('APP_URL')" color="success">
View Order
</x-mail::button>

Mensaje enviado desde el formulario de contacto,<br>
{{ config('app.name') }}
</x-mail::message>
