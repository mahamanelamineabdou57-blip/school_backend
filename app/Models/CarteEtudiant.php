<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarteEtudiant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'carte_etudiants';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'numero_carte',
        'inscriptions_id',
        'date_emission',
        'date_expiration',
        'status',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscriptions_id');
    }
}
