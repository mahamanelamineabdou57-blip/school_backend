<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formation extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nom',
        'code',
        'duree',
        'conditions',
        'departement_id'
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
