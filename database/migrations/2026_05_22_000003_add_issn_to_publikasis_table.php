<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publikasis', function (Blueprint $table) {
            $table->string('issn', 100)->nullable()->after('penulis');
        });
    }

    public function down(): void
    {
        Schema::table('publikasis', function (Blueprint $table) {
            $table->dropColumn('issn');
        });
    }
};
