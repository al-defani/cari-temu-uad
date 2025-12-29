<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-red-600 leading-tight uppercase tracking-tight">
                {{ __('Panel Kendali Admin') }}
            </h2>
            <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-[10px] font-bold uppercase">
                Admin Mode
            </span>
        </div>
    </x-slot>
    
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-6 p-4 bg-green-500 text-white rounded-2xl shadow-lg flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pengguna</p>
                    <p class="text-3xl font-black text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Laporan</p>
                    <p class="text-3xl font-black text-[#1e3a8a]">{{ $stats['total_items'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-red-500">Barang Hilang</p>
                    <p class="text-3xl font-black text-red-600">{{ $stats['items_hilang'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-green-500">Barang Temu</p>
                    <p class="text-3xl font-black text-green-600">{{ $stats['items_temu'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 sticky top-8">
                        <h3 class="font-black text-gray-800 uppercase text-sm mb-4 tracking-tight text-[#1e3a8a]">Tambah Kategori</h3>
                        
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Kategori Baru</label>
                                <input type="text" name="nama" required placeholder="Contoh: Elektronik" 
                                       class="w-full mt-1 border-gray-200 rounded-xl focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full bg-[#1e3a8a] text-white py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-blue-800 transition shadow-md shadow-blue-100">
                                Simpan Kategori
                            </button>
                        </form>

                        <div class="mt-8">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Kategori Saat Ini</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($categories as $cat)
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-[10px] font-bold border border-gray-200">
                                        {{ $cat->nama }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                        <div class="p-6">
                            <h3 class="font-black text-gray-800 uppercase text-sm mb-6 tracking-tight">Moderasi Semua Laporan</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 text-[10px] uppercase font-black text-gray-500 tracking-widest">
                                            <th class="p-4 border-b">Barang</th>
                                            <th class="p-4 border-b text-center">Jenis</th>
                                            <th class="p-4 border-b">Status</th>
                                            <th class="p-4 border-b text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($items as $item)
                                        <tr class="hover:bg-gray-50 transition group">
                                            <td class="p-4">
                                                <div class="font-bold text-sm text-gray-800 group-hover:text-blue-600 transition">{{ $item->nama_barang }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $item->user->name }} • {{ $item->created_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $item->jenis == 'hilang' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                    {{ $item->jenis }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <span class="text-[10px] font-black {{ $item->status == 'aktif' ? 'text-blue-500' : 'text-gray-300' }} uppercase">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-right">
                                                <div class="flex items-center justify-end space-x-3">
                                                    <a href="{{ route('items.show', $item->id) }}" class="text-gray-400 hover:text-blue-600 transition" title="Lihat Detail">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-300 hover:text-red-600 transition" title="Hapus Laporan">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="p-10 text-center text-gray-400 italic text-sm">Belum ada laporan masuk.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                {{ $items->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>