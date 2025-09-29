<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{

    use HasFactory;

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
}
