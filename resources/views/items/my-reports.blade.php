<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#1e3a8a] uppercase tracking-tight">Laporan Saya</h2>
                <p class="text-sm text-gray-600">Total: {{ $items->count() }} Laporan</p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-gray-400 uppercase text-xs">
                                <th class="py-3 px-4">Barang</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Tanggal Lapor</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded-md overflow-hidden mr-3 border">
                                                @if($item->foto)
                                                    <img src="{{ asset('storage/' . $item->foto) }}" class="object-cover h-full w-full">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <span class="font-bold text-gray-800">{{ $item->nama_barang }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $item->jenis == 'hilang' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                            {{ $item->jenis }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $item->status == 'aktif' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-400' }}">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>

                                    <td class="py-4 px-4">
                                        <div class="flex justify-center items-center space-x-3">
                                            
                                            {{-- TOMBOL TANDAI SELESAI --}}
                                            @if($item->status == 'aktif')
                                                <form action="{{ route('items.update', $item->id) }}" method="POST" onsubmit="return confirm('Tandai laporan ini sebagai SELESAI?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="nama_barang" value="{{ $item->nama_barang }}">
                                                    <input type="hidden" name="category_id" value="{{ $item->category_id }}">
                                                    <input type="hidden" name="deskripsi" value="{{ $item->deskripsi }}">
                                                    <input type="hidden" name="lokasi" value="{{ $item->lokasi }}">
                                                    <input type="hidden" name="telepon" value="{{ $item->telepon }}">
                                                    <input type="hidden" name="status" value="selesai">

                                                    <button type="submit" class="text-green-500 hover:text-green-700 transition transform hover:scale-110" title="Tandai Selesai">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('items.show', $item->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            <a href="{{ route('items.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-700 transition" title="Edit Laporan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus Laporan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-500 italic">
                                        Kamu belum pernah membuat laporan barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>