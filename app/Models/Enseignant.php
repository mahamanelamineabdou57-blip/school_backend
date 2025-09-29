<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    /**
     * Champs autorisés au remplissage en masse
     */
    protected $fillable = [
        'full name',
        'grade',
        'fonction',
        'phone_number',
        'speciality',
        'address',
        'date_of_birth',
        'photo_url',
        'email',
        'departement_id',
        'user_id',
    ];

    /* ---------------- Relations ---------------- */

    // Un enseignant appartient à un département
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    // Un enseignant appartient à un utilisateur (auth)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un enseignant enseigne plusieurs modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
     public function doyen()
    {
        // 'doyen' est le nom de la colonne dans ta table facultes qui contient l'ID du doyen
        return $this->belongsTo(Enseignant::class, 'doyen'); 
    }
}
