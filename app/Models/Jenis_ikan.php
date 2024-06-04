<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_ikan extends Model
{
    use HasFactory;
    protected $table = 'jenis_ikans';
    protected $guarded = ['id'];

    public function batas_optimal_suhu(){
        return $this->hasOne(Batas_optimal_suhu::class);
    }

    public function batas_optimal_ph()
    {
        return $this->hasOne(Batas_optimal_pH::class);
    }
}
