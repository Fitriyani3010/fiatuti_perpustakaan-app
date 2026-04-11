<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;


class KepalaDashboardController extends Controller
{
    //dashboard
    public function home()
    {
        $totalBuku = Buku::count();
        $totalAnggota = User::where('role', 'user')->count();
        $totalPeminjaman = Peminjaman::count();
        $totalDenda = Peminjaman::sum('denda');

        $petugas = User::where('role', 'petugas')->latest()->take(5)->get();
        $bukuPopuler = Buku::latest()->take(5)->get();

        $aktivitas = Peminjaman::latest()->take(5)->get();

    // 🔥 TAMBAH INI
    $statistik = Peminjaman::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as pinjam'),
            DB::raw('SUM(CASE WHEN status = "kembali" THEN 1 ELSE 0 END) as kembali')
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal','ASC')
        ->get()
        ->toArray();

        // ===== CHART 7 HARI =====
    $labels = [];
    $chartData = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');

        $labels[] = Carbon::parse($date)->format('d M');

        $chartData[] = Peminjaman::whereDate('created_at', $date)->count();
    }

    return view('kepala.home', compact(
        'totalBuku',
        'totalAnggota',
        'totalPeminjaman',
        'totalDenda',
        'aktivitas',
        'labels',
        'chartData'
    ));
    }

    //kelola petugas
    public function petugas(Request $request)
    {
        $petugas = User::where('role', 'petugas')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('kepala.petugas', compact('petugas'));
    }

    //tambah petugas
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_telepon' => 'required',
            'alamat' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan');
    }

    //update petugass
    public function updatePetugas(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telepon' => 'required',
            'alamat' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);
        return back()->with('success', 'Petugas berhasil diupdate');
    }

    //delete petugas
    public function deletePetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return back()->with('success', 'Petugas berhasil dihapus');
    }

    //laporan peminjaman
    public function laporanPeminjaman(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $query = Peminjaman::with(['user', 'buku'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun);

        $data = $query->paginate(10);

        return view('kepala.laporan.peminjaman', compact('data', 'bulan', 'tahun'));
    }

    //cetak laporan peminjaman
     public function cetaklaporanPeminjaman(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = Peminjaman::with(['user', 'buku'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->get();

        $pdf = pdf::loadView('kepala.laporan.cetak_peminjaman', compact('data', 'bulan', 'tahun'));
        return $pdf->stream('laporan-peminjaman-'.$bulan.'-'.$tahun.'.pdf');
    }
    //laporan denda
    public function laporanDenda()
    {
        $data = Peminjaman::with(['user','buku'])
            ->where('denda','>',0)
            ->latest()
            ->paginate(10);

        return view('kepala.laporan.denda', compact('data'));
    }

    //laporan anggota
    public function laporanAnggota(Request $request)
    {
        $query = User::where('role', 'user');

    // SEARCH (nama / email)
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    // FILTER KELAS
    if ($request->filled('kelas')) {
        $query->where('kelas', $request->kelas);
    }

    $data = $query->latest()->paginate(10)->withQueryString();

    return view('kepala.laporan.anggota', compact('data'));
    }

    public function profile()
{
    $user = auth()->user();
    return view('kepala.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'nisn' => $request->nisn,
        'no_telepon' => $request->no_telepon,
        'alamat' => $request->alamat,
    ]);

    // upload foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $namaFile = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/foto', $namaFile);

        $user->update([
            'foto' => $namaFile
        ]);
    }

    return back()->with('success', 'Profil berhasil diupdate!');
}

public function dataBuku(Request $request)
{
    $query = Buku::with('kategori');

   // SEARCH
if ($request->filled('search')) {
    $query->where('judul', 'like', '%' . $request->search . '%');
}

// FILTER KATEGORI
if ($request->kategori) {
    $query->where('kategori_id', $request->kategori);
}
    $dataBuku = $query->paginate(10);
    $kategori = Kategori::all();

    return view('kepala.data_buku', compact('dataBuku', 'kategori'));
}
public function detailBuku($id)
{
    $buku = Buku::with('kategori')->findOrFail($id);

    return view('kepala.detail_buku', compact('buku'));
}
}