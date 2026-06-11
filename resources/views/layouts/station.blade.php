<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>PickLight Station</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-900">
    {{ $slot }}

    @livewireScripts
</body>
</html>