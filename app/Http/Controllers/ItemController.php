<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Menampilkan form lapor
    public function create(Request $request)
    {
        // Mengambil jenis dari URL (misal: /lapor?jenis=hilang)
        $jenis = $request->query('jenis', 'hilang');
        $categories = Category::all();
        
        $lokasi = ['Gedung Utama', 'Masjid Islamic Center', 'Perpustakaan', 'Laboratorium', 'Kantin', 'Area Parkir'];
        
        return view('items.create', compact('categories', 'lokasi', 'jenis'));
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'category_id' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required|date',
            'telepon' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('items', 'public');
        }

        Item::create([
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'jenis' => $request->jenis, // hilang atau temu
            'user_id' => Auth::id(),
            'telepon' => $request->telepon,
            'foto' => $path,
            'status' => 'aktif',
        ]);



        return redirect()->route('dashboard')->with('success', 'Laporan berhasil terkirim!');
    }

    public function index(Request $request)
    {
        // 1. Ambil input dari filter
        $search = $request->input('search');
        $category = $request->input('category');
        $status = $request->input('status');
        $query = Item::query();

        // 2. Query data dengan filter (jika ada)
        $items = Item::with('category')
            ->when($search, function($query) use ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
            })
            ->when($category, function($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($status, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(8);

        // 3. Ambil kategori untuk isi dropdown
        $categories = Category::all();
        
        // Logika Pencarian
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                ->orWhere('lokasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $totalHilang = Item::where('jenis', 'hilang')->where('status', 'aktif')->count();
        $totalTemu = Item::where('jenis', 'temu')->where('status', 'aktif')->count();
        $totalSelesai = Item::where('status', 'selesai')->count();

        $items = $query->latest()->paginate(9);

        return view('dashboard', compact('items', 'categories', 'totalHilang', 'totalTemu', 'totalSelesai'));
    }

    public function show(Item $item)
    {
        // Kita panggil relasi category agar muncul nama kategorinya
        $item->load('category', 'user');
    
        return view('items.show', compact('item'));
    }

    public function landing()
    {
        // Mengambil 6 barang terbaru untuk ditampilkan di halaman depan
        $latestItems = Item::with('category')->where('status', 'aktif')->latest()->take(6)->get();
    
        // Hitung total barang hilang & temu untuk statistik simple
        $totalHilang = Item::where('jenis', 'hilang')->where('status', 'aktif')->count();
        $totalTemu = Item::where('jenis', 'temu')->where('status', 'aktif')->count();

        return view('welcome', compact('latestItems', 'totalHilang', 'totalTemu'));
    }

    public function myReports()
    {
        // Mengambil barang yang diupload oleh user yang sedang login saja
        $items = Item::with('category')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('items.my-reports', compact('items'));
    }

    public function edit(Item $item)
    {
        // Cek Keamanan: Pastikan yang edit adalah pemiliknya
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $categories = Category::all();
        $lokasi = ['Gedung Utama', 'Masjid Islamic Center', 'Perpustakaan', 'Laboratorium', 'Kantin', 'Area Parkir'];
    
        return view('items.edit', compact('item', 'categories', 'lokasi'));
    }

    public function update(Request $request, Item $item)
    {
        // 1. Cek kepemilikan
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        // 2. Validasi data
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required',
            'deskripsi'   => 'required',
            'telepon' => 'required|numeric',
            'status'      => 'required',
        ]);

        // 3. Eksekusi Update
        $item->update($request->all());

        // 4. Redirect dengan pesan sukses
        return redirect()->route('items.my-reports')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) { abort(403); }
    
        $item->delete();
        return redirect()->route('items.my-reports')->with('success', 'Laporan berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $items = \App\Models\Item::where('nama_barang', 'LIKE', "%$query%")
                    ->with('category') // Ini wajib ada agar JavaScript tidak error saat baca nama kategori
                    ->get();

        return response()->json($items);
    }
}
