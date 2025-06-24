<?php

namespace App\Models;

use App\Models\TahapanModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KegiatanTahapanModel extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_tahapan';
    protected $keyType = 'string';
    protected $fillable = ['id', 'nama', 'id_tahapan', ];
    public $incrementing = false;
    public $timestamps = true;

    public function tahapan()
    {
        return $this->belongsTo(TahapanModel::class, 'id_tahapan', 'id');
    }

    public function detil_status()
    {
        return $this->hasMany(DetilStatusModel::class, 'id_kegiatan_tahapan', 'id');
    }
}
