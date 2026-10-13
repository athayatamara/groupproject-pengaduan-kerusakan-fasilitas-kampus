<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    // Data uji agar dashboard dan riwayat langsung terisi
    public function run(): void
    {
        $mhs = User::where('email', 'athaya@kampus.test')->value('id');
        $dosen = User::where('email', 'budi@kampus.test')->value('id');

        $data = [
            [$mhs, 'Proyektor', 'Gedung B', 'Proyektor mati', 'Proyektor ruang B2.3 tidak menyala.', 'tinggi', 'diproses'],
            [$mhs, 'AC', 'Lab Komputer 1', 'AC bocor', 'AC meneteskan air ke meja.', 'sedang', 'selesai'],
            [$mhs, 'Internet', 'Perpustakaan', 'Wifi lambat', 'Wifi sering terputus.', 'rendah', 'ditolak'],
            [$dosen, 'Listrik', 'Gedung A', 'Listrik padam', 'Stop kontak ruang A1 tidak ada arus.', 'tinggi', 'menunggu'],
            [$dosen, 'Toilet', 'Gedung B', 'Toilet tersumbat', 'Toilet lantai 2 tersumbat.', 'sedang', 'menunggu'],
        ];

        foreach ($data as [$userId, $kategori, $lokasi, $judul, $deskripsi, $urgensi, $status]) {
            Report::create([
                'user_id' => $userId,
                'category_id' => Category::where('name', $kategori)->value('id'),
                'location_id' => Location::where('name', $lokasi)->value('id'),
                'title' => $judul,
                'description' => $deskripsi,
                'urgency' => $urgensi,
                'status' => $status,
                'rejection_reason' => $status === 'ditolak' ? 'Bukan kerusakan fasilitas kampus.' : null,
            ]);
        }
    }
}
