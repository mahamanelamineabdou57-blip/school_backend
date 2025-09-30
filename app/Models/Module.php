<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory;
   use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nom',
        'code',
        'credits',
        'ue_id'
    ]; 

    /* ---------------- Relations ---------------- */

    // Module appartient à une section
   
    public function unite_enseignements()
    {
        return $this->belongsTo(UniteEnseignement::class,'ue_id');
    }
}
