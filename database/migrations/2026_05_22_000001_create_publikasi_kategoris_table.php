<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publikasi_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Seed default categories
        DB::table('publikasi_kategoris')->insert([
            ['nama' => 'Buku',                 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Artikel',              'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Berita Kegiatan',      'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Foto/Video Kegiatan',  'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Jurnal Ilmiah',        'urutan' => 5, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Change kategori column from enum to varchar
        DB::statement("ALTER TABLE publikasis MODIFY COLUMN kategori VARCHAR(100) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE publikasis MODIFY COLUMN kategori ENUM('Buku','Artikel','Berita Kegiatan','Foto/Video Kegiatan') NOT NULL");
        Schema::dropIfExists('publikasi_kategoris');
    }
};
