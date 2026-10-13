<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'location_id', 'title', 'description',
        'urgency', 'status', 'photo', 'rejection_reason', 'admin_note',
        'repair_photo', 'rating',
    ];

    // Relasi dasar (dibahas lebih dalam pada pertemuan Relationship Eloquent).
    // Dipakai di sini agar view bisa menampilkan nama kategori/lokasi/pelapor.
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
        return $this->hasMany(ReportHistory::class);
    }
}
