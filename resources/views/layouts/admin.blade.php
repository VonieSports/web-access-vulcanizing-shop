<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
    <div class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col lg:flex-row">
        @include('layouts.admin.navbar')

        <div class="flex min-h-screen flex-1 flex-col">
            @include('layouts.admin.header')

            <main class="flex-1 overflow-x-hidden p-4 sm:p-6 lg:p-8">
                <div class="mx-auto ">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</div>

     @livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('adminSidebarToggle');
        const closeButton = document.getElementById('adminSidebarClose');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');

        const setSidebar = (open) => {
            if (!sidebar || !overlay) return;

            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full', !open);
                sidebar.classList.toggle('translate-x-0', open);
                overlay.classList.toggle('hidden', !open);
            } else {
                sidebar.classList.remove('-translate-x-full', 'translate-x-0');
                overlay.classList.add('hidden');
            }
        };

        if (toggle) {
            toggle.addEventListener('click', function () {
                const isOpen = !sidebar.classList.contains('translate-x-0');
                setSidebar(isOpen);
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', function () {
                setSidebar(false);
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                setSidebar(false);
            });
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                sidebar?.classList.remove('-translate-x-full', 'translate-x-0');
                overlay?.classList.add('hidden');
            }
        });
    });
</script>
   
    </body>
</html>
