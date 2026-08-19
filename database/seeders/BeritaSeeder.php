<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('beritas')->truncate();

        $beritas = [
            [
                'judul'     => 'PPKRI Gelar Pelatihan Penguatan Kapasitas Pemerintah Desa',
                'penulis'   => 'Tim Humas PPKRI',
                'ringkasan' => 'Pelatihan diikuti oleh 40 perangkat desa dari 10 kabupaten di Jawa Tengah, membahas pengelolaan dana desa dan pembangunan partisipatif.',
                'konten'    => 'Kegiatan berlangsung selama tiga hari dan menghadirkan narasumber dari Kementerian Desa PDTT serta praktisi tata kelola pemerintahan daerah. Peserta diajak berdiskusi mengenai praktik baik pengelolaan dana desa di berbagai wilayah.',
                'tanggal'   => '2026-07-10',
                'unggulan'  => true,
                'aktif'     => true,
            ],
            [
                'judul'     => 'Kerja Sama Baru dengan Pemerintah Kabupaten dalam Program Pemberdayaan Masyarakat',
                'penulis'   => 'Tim Humas PPKRI',
                'ringkasan' => 'Penandatanganan nota kesepahaman menandai dimulainya program pendampingan tiga tahun untuk penguatan ekonomi lokal.',
                'konten'    => 'Nota kesepahaman ditandatangani oleh Direktur PPKRI dan Bupati setempat, mencakup pendampingan UMKM dan pelatihan kewirausahaan bagi masyarakat di wilayah tersebut.',
                'tanggal'   => '2026-06-22',
                'unggulan'  => false,
                'aktif'     => true,
            ],
            [
                'judul'     => 'Refleksi Akhir Tahun: Capaian Program Tata Kelola Pemerintahan Daerah',
                'penulis'   => 'Tim Peneliti PPKRI',
                'ringkasan' => 'Diskusi publik menghadirkan pemangku kepentingan untuk mengevaluasi capaian dan tantangan program sepanjang tahun berjalan.',
                'konten'    => 'Acara refleksi tahunan ini menjadi ajang evaluasi bersama antara PPKRI, pemerintah daerah mitra, dan organisasi masyarakat sipil untuk merumuskan rencana kerja tahun berikutnya.',
                'tanggal'   => '2025-12-18',
                'unggulan'  => false,
                'aktif'     => true,
            ],
        ];

        foreach ($beritas as $b) {
            DB::table('beritas')->insert(array_merge($b, [
                'gambar'     => null,
                'slug'       => Str::slug($b['judul']) . '-' . time() . rand(100, 999),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
