<?php

namespace App\Models;

use App\Models\KegiatanSopModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahapanModel extends Model
{
    use HasFactory;

    protected $table = 'tahapan';
    protected $keyType = 'string';
    protected $fillable = ['id', 'judul','icon'];
    public $incrementing = false;
    public $timestamps = true;
    
    public function kegiatan_tahapan()
    {
        return $this->hasMany(KegiatanTahapanModel::class, 'id_tahapan', 'id');
    }
}
