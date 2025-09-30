<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculte extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // Champs remplissables en masse
    protected $fillable = [
        'nom',
        'logo',
    ];

    /**
     * Relation : une faculté possède plusieurs départements.
     */
    public function departements()
    {
        return $this->hasMany(Departement::class);
    }
    public function doyens()
    {
        return $this->belongsTo(Enseignant::class, 'faculte_id');
    }
}
