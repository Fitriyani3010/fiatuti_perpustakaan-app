<?php

namespace App\Models;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'bukti_pembayaran',
        'status_pembayaran',
    ];
    protected $casts = [
        'tanggal_pinjam'       => 'date',
        'tanggal_kembali'      => 'date',
        'tanggal_dikembalikan' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function buku()
{
     return $this->belongsTo(Buku::class, 'buku_id', 'id');
}

public function getTerlambatAttribute()
{
    if (!$this->tanggal_kembali) return 0;

    $batas = Carbon::parse($this->tanggal_kembali)->startOfDay();
    $today = now()->startOfDay();

    return $today->gt($batas)
        ? $batas->diffInDays($today)
        : 0;
}

public function getDendaOtomatisAttribute()
{
    return $this->terlambat * 5000 * $this->jumlah;
}
}
