<x-app-layout>
    <div class="min-h-screen bg-[#1e3a8a] py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="p-6 border-b text-center">
                    <h2 class="text-2xl font-bold text-gray-800 uppercase">Edit Laporan Barang</h2>
                </div>
                <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT') <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                            <input type="text" name="nama_barang" value="{{ $item->nama_barang }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Laporan</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md bg-blue-50">
                                <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Masih Aktif (Belum Ditemukan/Diambil)</option>
                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Ditemukan/Diambil)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Ubah ke 'Selesai' jika barang sudah kembali ke pemiliknya.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">Nomor WhatsApp</label>
                                <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">
                                    +62
                                </span>
                                <input type="number" name="telepon" value="{{ $item->telepon }}" 
                                    class="pl-12 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500" required>
                                </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" required>{{ $item->deskripsi }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('items.my-reports') }}" class="px-4 py-2 text-gray-600 border rounded-md hover:bg-gray-50">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-full font-bold shadow-md hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>