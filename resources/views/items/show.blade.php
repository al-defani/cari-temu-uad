<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="flex items-center text-blue-600 hover:text-blue-800 font-bold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    
                    <div class="md:w-1/2 bg-gray-200">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover min-h-[400px]">
                        @else
                            <div class="h-full flex flex-col items-center justify-center text-gray-400 p-20">
                                <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-lg">Foto tidak tersedia</p>
                            </div>
                        @endif
                    </div>

                    <div class="md:w-1/2 p-8 md:p-12">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest {{ $item->jenis == 'hilang' ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                                {{ $item->jenis }}
                            </span>
                            <span class="text-gray-400 text-sm">• {{ $item->created_at->format('d M Y') }}</span>
                        </div>

                        <h1 class="text-3xl font-black text-gray-800 mb-2 uppercase">{{ $item->nama_barang }}</h1>
                        
                        <div class="flex items-center text-blue-600 font-bold mb-6 bg-blue-50 w-fit px-3 py-1 rounded-lg">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                            {{ $item->category->nama ?? 'Umum' }}
                        </div>

                        <div class="space-y-6 text-gray-600">
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Kejadian</h3>
                                <p class="text-lg font-medium text-gray-800">{{ $item->lokasi }}</p>
                            </div>

                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Deskripsi Detail</h3>
                                <p class="leading-relaxed">{{ $item->deskripsi }}</p>
                            </div>

                            <div class="pt-6 border-t border-gray-100">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Dilaporkan Oleh</h3>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 leading-none">{{ $item->user->name }}</p>
                                        <p class="text-xs text-gray-400 mt-1 italic">Anggota Cari Temu UAD</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            @php
                                // Menghapus karakter selain angka untuk link WA
                                $phone = preg_replace('/[^0-9]/', '', $item->telepon ?? '0');
                                $message = "Halo " . $item->user->name . ", saya melihat laporan Anda di Cari Temu UAD mengenai " . $item->nama_barang . ".";
                            @endphp
                            
                            <a href="https://wa.me/{{ $phone }}?text={{ urlencode($message) }}" target="_blank" 
                               class="flex items-center justify-center w-full bg-[#25D366] hover:bg-[#128C7E] text-white py-4 rounded-2xl font-black text-lg shadow-lg transition duration-300">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.067 2.875 1.215 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>