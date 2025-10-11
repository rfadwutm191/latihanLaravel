<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkycRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'tanggal_lahir',
        'alamat',
        'file_ktp',
        'file_kk',
        'file_ijazah',
        'file_selfie'  
        
    ];

    //Relasi ke table users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
