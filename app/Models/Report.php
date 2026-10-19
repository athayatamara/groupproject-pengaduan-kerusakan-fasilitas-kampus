<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Daftar status dan urgensi (kunci = nilai di database, isi = label tampilan)
    public const STATUS = [
        'menunggu' => 'Menunggu',
        'diverifikasi' => 'Diverifikasi',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    public const URGENSI = [
        'rendah' => 'Rendah',
        'sedang' => 'Sedang',
        'tinggi' => 'Tinggi',
    ];

        // Alur perubahan status yang diperbolehkan (status sekarang => status berikutnya)
    public const ALUR = [
        'menunggu' => ['diverifikasi', 'ditolak'],
        'diverifikasi' => ['diproses'],
        'diproses' => ['selesai'],
        'selesai' => [],
        'ditolak' => [],
    ];
    
    protected $fillable = [
        'user_id', 'category_id', 'location_id', 'title', 'description',
        'urgency', 'status', 'photo', 'rejection_reason', 'admin_note',
        'repair_photo', 'rating',
    ];

    // Relasi dasar (dibahas lebih dalam pada pertemuan Relationship Eloquent)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function histories()
    {
        return $this->hasMany(ReportHistory::class)->orderBy('id');
    }
}
