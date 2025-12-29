<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Temu UAD - Lost & Found Kampus 4</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <nav class="flex items-center justify-between px-8 py-6 bg-white shadow-sm">
        <div class="text-2xl font-extrabold text-[#1e3a8a] tracking-tighter">
            CARI TEMU <span class="text-yellow-500">UAD</span>
        </div>
        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-bold text-[#1e3a8a] hover:text-blue-800">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-[#1e3a8a]">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-[#1e3a8a] text-white px-6 py-2 rounded-full font-bold hover:bg-blue-800 transition shadow-md">Daftar</a>
                @endauth
            @endif
        </div>
    </nav>

    <header class="relative py-20 px-8 overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0 z-10">
                <span class="inline-block px-4 py-1.5 mb-6 text-sm font-bold tracking-widest text-blue-600 uppercase bg-blue-50 rounded-full">
                    Solusi Kehilangan Barang di Kampus
                </span>
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight mb-6">
                    Kehilangan Barang <br> di <span class="text-[#1e3a8a]">Kampus 4 UAD?</span>
                </h1>
                <p class="text-lg text-gray-600 mb-10 max-w-lg leading-relaxed">
                    Platform resmi untuk melaporkan barang hilang atau temuan di area Kampus 4 Universitas Ahmad Dahlan. Mari saling bantu sesama Dahlan Muda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-[#1e3a8a] text-white rounded-2xl font-bold text-lg text-center shadow-xl hover:bg-blue-800 transition transform hover:-translate-y-1">
                        Cek Daftar Barang
                    </a>
                    <a href="{{ route('items.create') }}" class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-2xl font-bold text-lg text-center hover:bg-gray-50 transition">
                        Lapor Temuan
                    </a>
                </div>
            </div>
            
            <div class="md:w-1/2 relative">
                <div class="relative w-full h-[400px] bg-blue-100 rounded-[40px] overflow-hidden flex items-center justify-center border-4 border-white shadow-2xl rotate-3">
                     <svg class="w-48 h-48 text-[#1e3a8a] opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                     <div class="absolute bottom-6 right-6 bg-white p-4 rounded-2xl shadow-lg -rotate-6">
                         <p class="text-[10px] font-bold text-gray-400 uppercase">Barang Ditemukan</p>
                         <p class="text-2xl font-black text-green-600">Kunci Motor</p>
                     </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 bg-red-50 rounded-3xl border border-red-100 text-center">
                <p class="text-sm font-black text-red-600 uppercase tracking-widest mb-2">Barang Hilang</p>
                <h2 class="text-5xl font-black text-gray-900">{{ $totalHilang }}</h2>
                <p class="text-gray-500 mt-2 text-sm">Masih dicari pemiliknya</p>
            </div>

            <div class="p-8 bg-green-50 rounded-3xl border border-green-100 text-center">
                <p class="text-sm font-black text-green-600 uppercase tracking-widest mb-2">Barang Temu</p>
                <h2 class="text-5xl font-black text-gray-900">{{ $totalTemu }}</h2>
                <p class="text-gray-500 mt-2 text-sm">Menunggu diklaim</p>
            </div>

            <div class="p-8 bg-blue-50 rounded-3xl border border-blue-100 text-center">
                <p class="text-sm font-black text-[#1e3a8a] uppercase tracking-widest mb-2">Total Selesai</p>
                <h2 class="text-5xl font-black text-gray-900">{{ $totalSelesai }}</h2>
                <p class="text-gray-500 mt-2 text-sm">Berhasil dikembalikan</p>
            </div>
        </div>
    </div>
</section>

    <footer class="py-12 px-8 border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm italic">
            <p>&copy; 2024 Cari Temu UAD. Developed for Kampus 4 community.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-[#1e3a8a]">Pusat Bantuan</a>
                <a href="#" class="hover:text-[#1e3a8a]">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>