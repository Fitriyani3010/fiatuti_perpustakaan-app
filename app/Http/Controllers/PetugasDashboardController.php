<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PetugasDashboardController extends Controller
{
    //dashboard
    public function home()
    {
        $totalAnggota = User::where('role', 'user')->count();
        $totalBuku = Buku::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $totalDenda = 0;

$dataDenda = Peminjaman::where('status_pembayaran', '!=', 'lunas')->get();

foreach ($dataDenda as $item) {
    if ($item->tanggal_kembali) {
        $batas = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
        $today = now()->startOfDay();

        if ($today->greaterThan($batas)) {
            $terlambat = $batas->diffInDays($today);
            $denda = $terlambat * 5000 * $item->jumlah;

            $totalDenda += $denda;
        }
    }
}
        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $recentPeminjaman = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $chartData = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $chartData[] = Peminjaman::whereDate('created_at', $date)->count();
        }

        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->count();

        return view('petugas.home', compact(
            'totalAnggota',
            'totalBuku',
            'peminjamanAktif',
            'totalDenda',
            'menunggu',
            'recentPeminjaman',
            'chartData',
            'labels',
            'terlambat'
        ));
    }

    //anggota
    public function anggota(Request $request)
    {
        $anggotas = User::where('role', 'user')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('petugas.anggota', compact('anggotas'));
    }

   public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'stok' => 'required|integer',
        'kategori_id' => 'required|exists:kategoris,id',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png'
    ]);

    $data = $request->only([
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori_id',
        'deskripsi',
        'stok'
    ]);

    // 🔥 HANDLE COVER DENGAN BENAR
    if ($request->hasFile('cover')) {
        $data['cover'] = $request->file('cover')->store('buku', 'public');
    }

    Buku::create($data);

    return back()->with('success', 'Buku berhasil ditambahkan');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6' // 🔥 opsional
        ]);

        $user = User::findOrFail($id);

        $data = $request->only([
            'name',
            'email',
            'no_telepon',
            'alamat'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Anggota berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Anggota berhasil dihapus');
    }

    //buku
    public function buku(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('judul', 'like', "%{$request->search}%")
                        ->orWhere('penulis', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('petugas.buku', compact('bukus', 'kategoris'));
    }

   public function storeBuku(Request $request)
{
    $request->validate([
    'judul' => 'required',
    'penulis' => 'required',
    'stok' => 'required|integer|min:0',
    'kategori_id' => 'required|exists:kategoris,id',
]);

    $data = [
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'penerbit' => $request->penerbit,
        'tahun_terbit' => $request->tahun_terbit,
        'kategori_id' => $request->kategori_id,
        'deskripsi' => $request->deskripsi,
        'stok' => $request->stok,
    ];

    if ($request->hasFile('cover')) {
        $file = $request->file('cover');

        $filename = time().'_'.$file->getClientOriginalName();

        $file->storeAs('buku', $filename, 'public');

        $data['cover'] = 'buku/'.$filename;
    }

    Buku::create($data);

    return back()->with('success', 'Buku berhasil ditambahkan');
}
    public function updateBuku(Request $request, $id)
{
    $request->validate([
    'judul' => 'required',
    'penulis' => 'required',
    'stok' => 'required|integer|min:0',
]);
    $buku = Buku::findOrFail($id);

    $data = $request->only([
    'judul',
    'penulis',
    'penerbit',
    'tahun_terbit',
    'kategori_id',
    'deskripsi',
    'stok'
]);

if ($request->hasFile('cover')) {
    if ($buku->cover) {
        Storage::disk('public')->delete($buku->cover);
    }

    $data['cover'] = $request->file('cover')->store('buku', 'public');
}

$buku->update($data);
    

    return back()->with('success', 'Buku berhasil diupdate');
}

    public function deleteBuku($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return back()->with('success', 'Buku berhasil dihapus');
    }
    public function kategori()
    {
        $data = Kategori::latest()->get();
        return view('petugas.kategori', compact('data'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris,nama'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);

        return back()->with('success', 'Kategori ditambahkan');
    }

    public function deleteKategori($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori dihapus');
    }
    //peminjaman
    public function peminjaman(Request $request)
    {
        $data = Peminjaman::with(['user', 'buku'])

            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->whereHas('user', function ($qq) use ($request) {
                        $qq->where('name', 'like', '%' . $request->search . '%');
                    })
                        ->orWhereHas('buku', function ($qq) use ($request) {
                            $qq->where('judul', 'like', '%' . $request->search . '%');
                        });
                });
            })

            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('petugas.peminjaman', compact('data'));
    }
    //approvw pwminjaman
    public function approve($id)
    {
        $p = Peminjaman::with('buku')->findOrFail($id);

        if ($p->status != 'menunggu') {
            return back()->with('error', 'Sudah diproses');
        }

        if ($p->jumlah > $p->buku->stok) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $p->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(3),
        ]);

        $p->buku->decrement('stok', $p->jumlah);

        return back()->with('success', 'Disetujui');
    }

    //return buku
    public function returnBuku($id)
    {
        $p = Peminjaman::with('buku')->findOrFail($id);

        $today = now();
        $batas = Carbon::parse($p->tanggal_kembali);

        $terlambat = $today->gt($batas)
            ? $batas->diffInDays($today)
            : 0;

        $denda = 0;

        if ($terlambat > 0) {
            $dendaPerHari = 5000;
            $denda = $terlambat * $dendaPerHari * $p->jumlah;
        }

$p->update([
    'status' => 'dikembalikan',
    'tanggal_dikembalikan' => $today,
    'terlambat' => $terlambat,   // 🔥 TAMBAH INI
    'denda' => $denda,
    'status_pembayaran' => $denda > 0 ? 'belum' : 'lunas'
]);

        $p->buku->increment('stok', $p->jumlah);

        return back()->with('success', 'Buku dikembalikan');
    }

    //denda
   public function denda(Request $request)
{
    $data = Peminjaman::with(['user', 'buku'])
        ->latest()
        ->paginate(5);

    $totalDendaAktif = 0;
    $totalDendaLunas = 0;

    foreach ($data as $item) {

        $terlambat = 0;
        $denda = 0;

        // masih dipinjam
        if ($item->status != 'dikembalikan' && $item->tanggal_kembali) {

            $batas = Carbon::parse($item->tanggal_kembali)->startOfDay();
            $today = now()->startOfDay();

            if ($today->greaterThan($batas)) {
               $terlambat = (int) $batas->diffInDays($today);

$denda = (int) round($terlambat * 5000 * (int) $item->jumlah);
            }
        }

        // sudah dikembalikan tapi ada denda
        if ($item->status == 'dikembalikan' && $item->denda > 0) {
          $terlambat = (int) round($item->denda / (5000 * (int) $item->jumlah));
            $denda = $item->denda;
        }

        $item->terlambat = $terlambat;
        $item->total_denda = $denda;

        // total global
        if ($item->status == 'dikembalikan') {
            $totalDendaLunas += $denda;
        } else {
            $totalDendaAktif += $denda;
        }
    }

    return view('petugas.denda', compact(
        'data',
        'totalDendaAktif',
        'totalDendaLunas'
    ));
}
    public function profile()
{
    $user = auth()->user();
    return view('petugas.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $user->update($request->all());

    return back()->with('success', 'Profil berhasil diupdate');
}
public function lunaskan($id)
{
    $p = Peminjaman::findOrFail($id); // ✅ BENAR

    $p->status_pembayaran = 'lunas';
    $p->save();

    return back()->with('success', 'Denda berhasil dilunasi');
}
}
