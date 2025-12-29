<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk - Cari Temu UAD</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#1e3a8a]">
            <div>
                <a href="/" class="text-white text-3xl font-black uppercase tracking-widest">
                    Cari Temu <span class="text-yellow-400">UAD</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-yellow-500">
                {{ $slot }}
            </div>
            
            <p class="mt-6 text-blue-200 text-sm">
                &copy; 2024 Lost & Found Kampus 4 UAD
            </p>
        </div>
    </body>
</html>