<?php

namespace App\Http\Controllers;

use App\Models\KlienMitra;
use App\Models\Pengalaman;
use App\Models\Profile;

class KlienMitraController extends Controller
{
    public function index()
    {
        $kategoriOrder = [
            'Kementerian/Lembaga',
            'Pemerintah Daerah',
            'OPD/Instansi Teknis',
            'BUMD',
            'Lembaga Pendidikan',
            'Dunia Usaha',
            'Lembaga Mitra',
            'Lainnya',
        ];

        // ── 1. Data master klien_mitras (jika ada) ──────────────────
        $masterKlien = KlienMitra::aktif()->orderBy('urutan')->orderBy('nama')->get()
            ->keyBy(fn($k) => strtolower(trim($k->nama)));

        // ── 2. Semua pengalaman aktif, grouped by klien ──────────────
        $pengalamans = Pengalaman::where('aktif', true)
            ->with('layanan')
            ->orderByDesc('tahun')
            ->get();

        $pengalamanGrouped = $pengalamans->groupBy(fn($p) => trim($p->klien));

        // ── 3. Bangun daftar klien dari data pengalaman ──────────────
        $allClients = collect();
        $idCounter  = 1000000; // offset ID untuk klien non-DB

        foreach ($pengalamanGrouped as $namaKlien => $proyeks) {
            $key    = strtolower(trim($namaKlien));
            $master = $masterKlien->get($key);

            $jenisKlien = $proyeks->first()->jenis_klien ?? '';
            $kategori   = $this->resolveKategori($jenisKlien, $master?->kategori);

            if ($master) {
                $client = (object)[
                    'id'       => $master->id,
                    'nama'     => $master->nama,
                    'kategori' => $master->kategori ?: $kategori,
                    'logo'     => $master->logo,
                    'website'  => $master->website,
                ];
            } else {
                $client = (object)[
                    'id'       => $idCounter++,
                    'nama'     => $namaKlien,
                    'kategori' => $kategori,
                    'logo'     => null,
                    'website'  => null,
                ];
            }

            $allClients->push($client);
        }

        // ── 4. Tambahkan klien master yang tidak punya pengalaman ────
        foreach ($masterKlien as $key => $master) {
            $sudahAda = $allClients->contains(fn($c) => strtolower(trim($c->nama)) === $key);
            if (!$sudahAda) {
                $allClients->push((object)[
                    'id'       => $master->id,
                    'nama'     => $master->nama,
                    'kategori' => $master->kategori,
                    'logo'     => $master->logo,
                    'website'  => $master->website,
                ]);
            }
        }

        // ── 5. Sort & Group ──────────────────────────────────────────
        $allClients = $allClients->sortBy('nama')->values();
        $grouped    = $allClients->groupBy('kategori');

        // ── 6. Build pengalamanMap untuk modal proyek ────────────────
        $pengalamanMap = $pengalamans->groupBy(fn($p) => trim($p->klien));

        // ── 7. Build allClientData untuk JS ─────────────────────────
        $allClientData = [];
        foreach ($allClients as $client) {
            $proyek = $pengalamanMap->get($client->nama, collect());
            $allClientData[$client->id] = [
                'nama'     => $client->nama,
                'kategori' => $client->kategori,
                'logo'     => $client->logo ? \Storage::url($client->logo) : '',
                'inisial'  => strtoupper(mb_substr($client->nama, 0, 1)),
                'proyek'   => $proyek->map(fn($p) => [
                    'judul'     => $p->judul,
                    'tahun'     => $p->tahun,
                    'lokasi'    => $p->lokasi,
                    'layanan'   => $p->layanan?->judul,
                    'deskripsi' => $p->deskripsi,
                ])->values()->toArray(),
            ];
        }

        $profile = Profile::first();

        return view('klien-mitra', compact('grouped', 'kategoriOrder', 'pengalamanMap', 'allClientData', 'profile'));
    }

    /**
     * Petakan jenis_klien dari pengalaman → kategori standar.
     */
    private function resolveKategori(?string $jenisKlien, ?string $existing): string
    {
        if ($existing) return $existing;
        if (!$jenisKlien) return 'Lainnya';

        $j = strtolower($jenisKlien);

        if (str_contains($j, 'kementerian') || str_contains($j, 'lembaga negara') || str_contains($j, 'badan nasional')) {
            return 'Kementerian/Lembaga';
        }
        if (str_contains($j, 'pemerintah daerah') || str_contains($j, 'pemda') || str_contains($j, 'kabupaten') || str_contains($j, 'kota') || str_contains($j, 'provinsi') || str_contains($j, 'bappeda') || str_contains($j, 'bkd')) {
            return 'Pemerintah Daerah';
        }
        if (str_contains($j, 'opd') || str_contains($j, 'dinas') || str_contains($j, 'instansi') || str_contains($j, 'badan') || str_contains($j, 'kantor')) {
            return 'OPD/Instansi Teknis';
        }
        if (str_contains($j, 'bumd') || str_contains($j, 'bumn')) {
            return 'BUMD';
        }
        if (str_contains($j, 'universitas') || str_contains($j, 'sekolah') || str_contains($j, 'pendidikan') || str_contains($j, 'perguruan')) {
            return 'Lembaga Pendidikan';
        }
        if (str_contains($j, 'usaha') || str_contains($j, 'perusahaan') || str_contains($j, 'swasta') || str_contains($j, 'cv') || str_contains($j, 'pt ')) {
            return 'Dunia Usaha';
        }
        if (str_contains($j, 'lsm') || str_contains($j, 'ngo') || str_contains($j, 'yayasan') || str_contains($j, 'mitra')) {
            return 'Lembaga Mitra';
        }

        return 'Lainnya';
    }
}
