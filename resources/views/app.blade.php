<!DOCTYPE html>
<html lang="sk" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @unless(app()->runningUnitTests())
        @vite(['resources/css/app.css', 'resources/ts/app.ts'])
    @endunless

    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>