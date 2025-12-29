<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_items' => \App\Models\Item::count(),
            'items_hilang' => \App\Models\Item::where('jenis', 'hilang')->count(),
            'items_temu' => \App\Models\Item::where('jenis', 'temu')->count(),
        ];

        $items = \App\Models\Item::with(['user', 'category'])->latest()->paginate(10);
    
        // WAJIB: Ambil data kategori untuk ditampilkan di sidebar
        $categories = \App\Models\Category::all(); 

        return view('admin.dashboard', compact('stats', 'items', 'categories'));
    }

    /**
     * Menghapus laporan yang dianggap melanggar/spam
     */
    public function destroy(Item $item)
    {
        // Hapus foto dari storage jika ada
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return back()->with('success', 'Laporan berhasil dihapus oleh Admin.');
    }

    public function storeCategory(Request $request)
{
    $request->validate([
        'nama' => 'required|unique:categories,nama|max:50'
    ]);

    \App\Models\Category::create([
        'nama' => $request->nama,
        'slug' => \Illuminate\Support\Str::slug($request->nama)
    ]);

    return back()->with('success', 'Kategori berhasil ditambahkan!');
}
}