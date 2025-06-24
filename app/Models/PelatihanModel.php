<?php

namespace App\Models;

use App\Models\StatusModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';
    protected $fillable = [
        'id', 'nama', 'id_jenis', 'id_bidang', 'id_model','tanggal_mulai', 'tanggal_selesai', 'tahun_periode'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function jenis_pelatihan()
    {
        return $this->belongsTo(JenisPelatihanModel::class, 'id_jenis', 'id');
    }
    public function bidang_pelatihan()
    {
        return $this->belongsTo(BidangPelatihanModel::class, 'id_bidang', 'id');
    }
    public function model_pelatihan()
    {
        return $this->belongsTo(ModelPelatihanModel::class, 'id_model', 'id');
    }
    
    public function status()
    {
        return $this->hasMany(StatusModel::class, 'id_pelatihan', 'id');
    }
    
}
