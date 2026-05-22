<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('journals_gambar')->nullable()->after('hero_images');
            $table->string('journals_url', 500)->nullable()->after('journals_gambar');
            $table->string('journals_deskripsi', 400)->nullable()->after('journals_url');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['journals_gambar', 'journals_url', 'journals_deskripsi']);
        });
    }
};
