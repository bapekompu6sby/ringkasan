<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanSopModel extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_sop';
    protected $keyType = 'string';
    protected $fillable = ['id', 'nama','deskripsi', 'id_sop', ];
    public $incrementing = false;
    public $timestamps = true;

    public function sop()
    {
        return $this->belongsTo(SopModel::class, 'id_sop', 'id');
    }
}
