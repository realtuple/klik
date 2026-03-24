<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @routes
    @vite(['resources/css/app.css', 'resources/js/App.ts'])
    @inertiaHead
</head>
<body class="dark:bg-gray-950 dark:text-white">
    @inertia
</body>
</html>
