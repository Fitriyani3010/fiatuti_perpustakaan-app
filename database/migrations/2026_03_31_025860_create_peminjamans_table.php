<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');

            // TANGGAL (🔥 dibuat fleksibel)
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->date('tanggal_dikembalikan')->nullable();

            // STATUS (🔥 ditambah menunggu)
            $table->enum('status', [
                'menunggu',
                'dipinjam',
                'dikembalikan',
                'terlambat'
            ])->default('menunggu');

            // DENDA
            $table->integer('denda')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};