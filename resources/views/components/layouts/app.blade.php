<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{ seo()->render() }}

    @stack('head')

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-base leading-normal tracking-normal text-gray-800">
    <div class="flex flex-col min-h-screen">
        <x-sections.header />

        <div class="flex-1">
            {{ $slot }}
        </div>

        <x-sections.footer />
    </div>

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />
    @stack('scripts')
</body>

</html>
