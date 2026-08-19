<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('type')->default('route'); // route | halaman | external
            $table->string('route_name')->nullable();
            $table->foreignId('halaman_id')->nullable()->constrained('halamans')->nullOnDelete();
            $table->string('url')->nullable(); // raw href for type=external
            $table->foreignId('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->integer('urutan')->default(0);
            $table->boolean('is_button')->default(false);
            $table->string('target')->default('_self'); // _self | _blank
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Seed the current hardcoded navbar so `migrate` alone reproduces
        // today's menu with zero visual change on a live site.
        if (DB::table('menus')->count() === 0) {
            $now = now();
            DB::table('menus')->insert([
                ['label' => 'Beranda',      'type' => 'route', 'route_name' => 'beranda',      'urutan' => 1, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Tentang Kami', 'type' => 'route', 'route_name' => 'tentang-kami', 'urutan' => 2, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Layanan',      'type' => 'route', 'route_name' => 'layanan',      'urutan' => 3, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Pengalaman',   'type' => 'route', 'route_name' => 'pengalaman',   'urutan' => 4, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Klien/Mitra',  'type' => 'route', 'route_name' => 'klien-mitra',  'urutan' => 5, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Testimoni',    'type' => 'route', 'route_name' => 'testimoni',    'urutan' => 6, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Publikasi',    'type' => 'route', 'route_name' => 'publikasi',    'urutan' => 7, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Berita',       'type' => 'route', 'route_name' => 'berita',       'urutan' => 8, 'is_button' => false, 'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
                ['label' => 'Kontak',       'type' => 'route', 'route_name' => 'kontak',       'urutan' => 9, 'is_button' => true,  'target' => '_self', 'aktif' => true, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
