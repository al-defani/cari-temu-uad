<x-app-layout>
    <div class="min-h-screen bg-[#1e3a8a] pb-12">
        <div class="max-w-4xl mx-auto pt-10 px-4">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">

                <div class="p-6 border-b text-center">
                    <h2 class="text-2xl font-bold text-gray-800 uppercase">
                        Form Laporan Barang Yang {{ $jenis == 'hilang' ? 'Hilang' : 'Ditemukan' }}
                    </h2>
                </div>

                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <input type="hidden" name="jenis" value="{{ $jenis }}">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                            <input type="text" name="nama_barang" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Kunci Motor Honda" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Ciri-ciri</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Sebutkan ciri spesifik barang..." required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi {{ $jenis == 'hilang' ? 'Kehilangan' : 'Ditemukan' }}</label>
                            <select name="lokasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($lokasi as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">
                                    +62
                                </span>
                                <input type="number" name="telepon" placeholder="81234567xxx" 
                                    class="pl-12 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500" required>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1">*Awali langsung dengan angka 8 (tanpa nol di depan).</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Foto Barang (Opsional)</label>
                            <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <button type="submit" class="bg-[#2563eb] hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-full shadow-lg transition duration-300">
                            Kirim Laporan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>