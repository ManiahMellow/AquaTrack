<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batas_optimal_pH extends Model
{
    use HasFactory;

    protected $table = 'batas_optimal_p_h_s';
    protected $guarded = ['id'];

    public function jenis_ikans(){
        return $this->belongsTo(Jenis_ikan::class);
    }
}
