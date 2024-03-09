<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periode';

    protected $guarded = ['id'];

    protected $fillable = [
        'periode_name',
        'status',
    ];

    public function riwayatPelatihan()
    {
        return $this->hasMany(RiwayatPelatihan::class, 'periode_id');
    }
}
