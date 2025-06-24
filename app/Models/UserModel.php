<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    // protected $guarded = ['id'];
    protected $fillable=['id','role','nip','nama_lengkap', 'password'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isSupervisi()
    {
        return $this->role === 'supervisi';
    }
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }
}
