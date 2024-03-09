<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelatihanWajibPerPeriode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelatihan_wajib_per_periode';

    protected $fillable = [
        'periode_id',
        'nama_pelatihan',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
