<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 bg-green-500 text-white rounded-xl shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-[#1e3a8a] tracking-tight text-red-600">DASHBOARD LAPORAN</h1>
                    <p class="text-gray-600">Temukan atau laporkan barang yang hilang di Kampus 4 UAD</p>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('items.create', ['jenis' => 'hilang']) }}" class="bg-red-600 text-white px-6 py-2.5 rounded-full shadow-lg hover:bg-red-700 transition font-bold text-sm uppercase">
                        Lapor Kehilangan
                    </a>
                    <a href="{{ route('items.create', ['jenis' => 'temu']) }}" class="bg-green-600 text-white px-6 py-2.5 rounded-full shadow-lg hover:bg-green-700 transition font-bold text-sm uppercase">
                        Lapor Temuan
                    </a>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm mb-8 border border-gray-200">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                    
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                        <select name="category" id="categoryFilter" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                        <select name="status" id="statusFilter" class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif (Belum Selesai)</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="flex-[2] min-w-[250px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Cari Nama Barang (Live Search)</label>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                               placeholder="Ketik untuk mencari secara instan..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500">
                    </div>

                    <div class="flex items-end space-x-2 pt-5">
                        <button type="submit" class="bg-[#1e3a8a] hover:bg-blue-800 text-white px-8 py-2 rounded-lg font-bold transition shadow-md">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'category', 'status']))
                            <a href="{{ route('dashboard') }}" class="text-sm text-red-600 hover:underline px-2">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <div id="itemGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($items as $item)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 group">
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs">Tidak ada foto</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm {{ $item->jenis == 'hilang' ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                                    {{ $item->jenis }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[10px] text-blue-600 font-bold uppercase tracking-tighter bg-blue-50 px-2 py-0.5 rounded">
                                    {{ $item->category->nama ?? 'Umum' }}
                                </span>
                                <span class="text-[10px] text-gray-400 italic">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="font-bold text-lg text-gray-800 truncate mb-1" title="{{ $item->nama_barang }}">
                                {{ $item->nama_barang }}
                            </h3>

                            <div class="space-y-1 mb-4">
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $item->lokasi }}
                                </p>
                                <p class="text-[11px] font-bold {{ $item->status == 'aktif' ? 'text-blue-500' : 'text-gray-400 line-through' }}">
                                    STATUS: {{ strtoupper($item->status) }}
                                </p>
                            </div>
                            
                            <a href="{{ route('items.show', $item->id) }}" class="block text-center bg-[#1e3a8a] hover:bg-blue-800 text-white py-2.5 rounded-xl text-sm font-bold shadow-md transition duration-300">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div id="emptyMessage" class="col-span-full bg-white rounded-2xl p-20 text-center shadow-sm border-2 border-dashed border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Barang tidak ditemukan</h3>
                    </div>
                @endforelse
            </div>

            <div id="paginationWrapper" class="mt-10">
                {{ $items->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const itemGrid = document.getElementById('itemGrid');
            const paginationWrapper = document.getElementById('paginationWrapper');

            searchInput.addEventListener('input', function() {
                let query = searchInput.value;

                // Jika query kosong, biarkan user tekan filter manual atau refresh
                // Tapi kita tetap jalankan fetch untuk live experience
                fetch(`/items/search?q=${query}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        // Sembunyikan pagination saat mencari
                        paginationWrapper.style.display = query.length > 0 ? 'none' : 'block';
                        itemGrid.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(item => {
                                const badgeColor = item.jenis === 'hilang' ? 'bg-red-600' : 'bg-green-600';
                                const categoryName = item.category ? item.category.nama : 'Umum';
                                const itemFoto = item.foto 
                                    ? `<img src="/storage/${item.foto}" class="w-full h-full object-cover">`
                                    : `<div class="w-full h-full flex items-center justify-center text-gray-400"><span class="text-xs">Tidak ada foto</span></div>`;

                                itemGrid.innerHTML += `
                                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                                        <div class="relative h-48 bg-gray-200">
                                            ${itemFoto}
                                            <div class="absolute top-3 left-3">
                                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase text-white ${badgeColor}">
                                                    ${item.jenis}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <span class="text-[10px] text-blue-600 font-bold uppercase">${categoryName}</span>
                                            <h3 class="font-bold text-lg text-gray-800 truncate mb-1">${item.nama_barang}</h3>
                                            <p class="text-sm text-gray-600 mb-4">${item.lokasi}</p>
                                            <a href="/items/${item.id}" class="block text-center bg-[#1e3a8a] text-white py-2 rounded-xl text-sm font-bold">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            itemGrid.innerHTML = '<div class="col-span-full text-center py-20 bg-white rounded-2xl border-2 border-dashed"><p class="text-gray-500">Barang tidak ditemukan.</p></div>';
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        });
    </script>
    
</x-app-layout>