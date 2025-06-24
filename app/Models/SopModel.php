<?php

namespace App\Models;

use App\Models\KegiatanSopModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SopModel extends Model
{
    use HasFactory;

    protected $table = 'sop';
    protected $keyType = 'string';
    protected $fillable = ['id', 'nama', 'icon'];
    public $incrementing = false;
    public $timestamps = true;
    
    public function kegiatan_sop()
    {
        return $this->hasMany(KegiatanSopModel::class, 'id_sop', 'id');
    }
}
