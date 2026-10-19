<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    // Data uji lengkap dengan riwayat status agar dashboard, riwayat, dan detail langsung terisi
    public function run(): void
    {
        $admin = User::where('email', 'admin@kampus.test')->value('id');
        $mhs = User::where('email', 'athaya@kampus.test')->value('id');
        $dosen = User::where('email', 'budi@kampus.test')->value('id');

        // [pelapor, kategori, lokasi, judul, deskripsi, urgensi, status]
        $data = [
            [$mhs, 'Proyektor', 'Gedung B', 'Proyektor mati', 'Proyektor ruang B2.3 tidak menyala saat perkuliahan.', 'tinggi', 'diproses'],
            [$mhs, 'AC', 'Lab Komputer 1', 'AC bocor', 'AC meneteskan air ke meja komputer.', 'sedang', 'selesai'],
            [$mhs, 'Internet', 'Perpustakaan', 'Wifi lambat', 'Wifi sering terputus di lantai 1.', 'rendah', 'ditolak'],
            [$dosen, 'Listrik', 'Gedung A', 'Listrik padam', 'Stop kontak ruang A1 tidak ada arus.', 'tinggi', 'menunggu'],
            [$dosen, 'Toilet', 'Gedung B', 'Toilet tersumbat', 'Toilet lantai 2 tersumbat.', 'sedang', 'menunggu'],
            [$mhs, 'Ruang kelas', 'Gedung A', 'Kursi patah', 'Dua kursi di ruang A2.1 patah kakinya.', 'rendah', 'diverifikasi'],
            [$dosen, 'AC', 'Gedung B', 'AC tidak dingin', 'AC ruang dosen hanya mengeluarkan angin.', 'sedang', 'diproses'],
            [$mhs, 'Lainnya', 'Kantin', 'Lampu kantin berkedip', 'Lampu sisi timur kantin berkedip terus.', 'rendah', 'selesai'],
            [$dosen, 'Internet', 'Lab Komputer 1', 'Jaringan lab putus', 'Seluruh komputer lab tidak bisa mengakses internet.', 'tinggi', 'selesai'],
            [$mhs, 'Toilet', 'Masjid Kampus', 'Keran wudu bocor', 'Keran wudu putra bocor deras.', 'sedang', 'menunggu'],
            [$dosen, 'Proyektor', 'Gedung A', 'Kabel HDMI rusak', 'Kabel HDMI proyektor A1 putus.', 'rendah', 'diverifikasi'],
            [$mhs, 'Ruang kelas', 'Perpustakaan', 'Papan tulis retak', 'Papan tulis ruang diskusi retak.', 'rendah', 'menunggu'],
        ];

        $urutan = ['menunggu', 'diverifikasi', 'diproses', 'selesai'];
        $catatan = [
            'menunggu' => 'Laporan dibuat',
            'diverifikasi' => 'Laporan diverifikasi oleh admin',
            'diproses' => 'Perbaikan sedang dikerjakan',
            'selesai' => 'Perbaikan telah selesai',
            'ditolak' => 'Bukan kerusakan fasilitas kampus',
        ];

        foreach ($data as [$userId, $kategori, $lokasi, $judul, $deskripsi, $urgensi, $status]) {
            $alur = $status === 'ditolak'
                ? ['menunggu', 'ditolak']
                : array_slice($urutan, 0, array_search($status, $urutan) + 1);

            $laporan = new Report([
                'user_id' => $userId,
                'category_id' => Category::where('name', $kategori)->value('id'),
                'location_id' => Location::where('name', $lokasi)->value('id'),
                'title' => $judul,
                'description' => $deskripsi,
                'urgency' => $urgensi,
                'status' => $status,
                'rejection_reason' => $status === 'ditolak' ? $catatan['ditolak'] : null,
                'admin_note' => $status === 'selesai' ? $catatan['selesai'] : null,
            ]);
            $laporan->created_at = $laporan->updated_at = now()->subDays(count($alur));
            $laporan->save();

            foreach ($alur as $i => $s) {
                $riwayat = new ReportHistory([
                    'report_id' => $laporan->id,
                    'changed_by' => $s === 'menunggu' ? $userId : $admin,
                    'status' => $s,
                    'note' => $catatan[$s],
                ]);
                $riwayat->created_at = $riwayat->updated_at = now()->subDays(count($alur) - $i);
                $riwayat->save();
            }
        }
    }
}
