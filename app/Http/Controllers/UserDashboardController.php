<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    // ===============================
    // DASHBOARD
    // ===============================
    public function home(Request $request)
    {
        $user = Auth::user();

        $bukuDipinjam = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->sum('jumlah');

        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();

        $dendaAktif = Peminjaman::where('user_id', $user->id)
            ->where('denda', '>', 0)
            ->sum('denda');

        $kategoris = Kategori::all();

       $bukuPopuler = Buku::with('kategori')
    ->when($request->kategori, function ($q) use ($request) {
        $q->where('kategori_id', $request->kategori);
    })
    ->latest()
    ->paginate(8)
    ->appends($request->only('kategori'));

        return view('user.home', compact(
            'bukuDipinjam',
            'totalPeminjaman',
            'dendaAktif',
            'kategoris',
            'bukuPopuler'
        ));
    }

    // ===============================
    // DETAIL BUKU
    // ===============================
    public function detailBuku($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        $rekomendasi = Buku::where('id', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

        $pinjaman = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->first();

        return view('user.detail_buku', compact(
            'buku',
            'rekomendasi',
            'pinjaman'
        ));
    }

    // ===============================
    // PINJAM (MENUNGGU APPROVAL)
    // ===============================
    public function pinjam(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:5'
        ]);

        $userId = Auth::id();
        $buku = Buku::findOrFail($id);
        $jumlah = (int) $request->jumlah;

        // ❗ CEK STOK
        if ($jumlah > $buku->stok) {
            return back()->with('error', 'Stok tidak cukup');
        }

        // ❗ CEK SUDAH PINJAM / MENUNGGU
        $cek = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah meminjam / menunggu buku ini');
        }

        // ❗ BATAS MAX 5 BUKU AKTIF
        // ❗ BATAS MAX 5 BUKU (TERMASUK MENUNGGU)
        $totalDipinjam = Peminjaman::where('user_id', $userId)
            ->whereIn('status', ['dipinjam', 'menunggu'])
            ->sum('jumlah');

        if ($totalDipinjam + $jumlah > 5) {
            return back()->with('error', 'Maksimal 5 buku (termasuk yang menunggu)');
        }

        // ✅ SIMPAN (STATUS MENUNGGU)
        Peminjaman::create([
            'user_id' => $userId,
            'buku_id' => $id,
            'jumlah' => $jumlah,
            'status' => 'menunggu',
            'tanggal_pinjam' => now(),
        ]);

        return back()->with('success', 'Menunggu persetujuan petugas');
    }

    // ===============================
    // RETURN BUKU
    // ===============================
    public function returnBuku($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);
        $userId = Auth::id();

        if ($peminjaman->user_id != $userId) {
            return back()->with('error', 'Akses ditolak');
        }

        if ($peminjaman->status != 'dipinjam') {
            return back()->with('error', 'Buku tidak bisa dikembalikan');
        }

        $hari = Carbon::parse($peminjaman->tanggal_pinjam)
            ->diffInDays(now());

        $denda = 0;

        if ($hari > 1) {
            $dendaPerBuku = 20000 + (($hari - 1) * 5000);
            $denda = $dendaPerBuku * $peminjaman->jumlah;
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
            'denda' => $denda
        ]);

        // 🔥 KEMBALIKAN STOK SESUAI JUMLAH
        $peminjaman->buku->increment('stok', $peminjaman->jumlah);

        return back()->with('success', 'Buku dikembalikan. Denda: Rp ' . number_format($denda));
    }

    // ===============================
    // LIBRARY
    // ===============================
    public function library(Request $request)
    {
        $books = Buku::with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('judul', 'like', "%{$request->search}%")
                        ->orWhere('penulis', 'like', "%{$request->search}%");
                });
            })
            ->when($request->kategori, function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            })
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('user.library', compact('books', 'kategoris'));
    }

    // ===============================
    // RIWAYAT
    // ===============================
    public function riwayat(Request $request)
    {
        $query = Peminjaman::with('buku')
            ->where('user_id', Auth::id());

        if ($request->search) {
            $query->whereHas('buku', function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%');
            });
        }

        $riwayats = $query->latest()
            ->paginate(5)
            ->withQueryString();

        return view('user.riwayat', compact('riwayats'));
    }

    // ===============================
    // DENDA
    // ===============================
    public function denda()
    {
        $denda = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where('denda', '>', 0)
            ->latest()
            ->paginate(5);

        $totalDenda = $denda->sum('denda');

        return view('user.denda', compact('denda', 'totalDenda'));
    }

    // ===============================
    // PROFILE
    // ===============================
    public function profile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    // ===============================
    // UPDATE PROFILE
    // ===============================
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return back()->with('success', 'Profile updated');
    }
}
