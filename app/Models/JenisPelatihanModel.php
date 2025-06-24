<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelatihan';

    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'nama',
    ];
    
    public function pelatihan()
    {
        return $this->hasMany(PelatihanModel::class, 'id_jenis', 'id');
    }
}
