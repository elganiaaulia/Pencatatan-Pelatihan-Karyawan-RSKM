<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPelatihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_pelatihan';

    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'periode_id',
        'nama_pelatihan',
        'nama_penyelenggara',
        'bukti_pelatihan',
        'tgl_mulai',
        'tgl_selesai',
        'durasi',
        'wajib',
        'verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
