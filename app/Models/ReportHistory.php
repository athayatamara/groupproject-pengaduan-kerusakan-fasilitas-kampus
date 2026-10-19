<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportHistory extends Model
{
    protected $fillable = ['report_id', 'changed_by', 'status', 'note'];

    // Pengguna yang mengubah status
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
