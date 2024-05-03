<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KaryawanPerPeriode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karyawan_per_periode';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'periode_id',
        'presentase',
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