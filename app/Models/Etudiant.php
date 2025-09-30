<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * Colonnes qui peuvent être remplies en masse (mass assignment)
     */

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'dateNaissance',
        'lieuNaissance',
        'email',
        'telephone',
        'adresse',
        'photo',
        'contact_nom',
        'contact_prenom',
        'contact_telephone',
        'contact_email',
        'contact_lien',
        // 'createdAt',
        // 'updatedAt',
        // 'deletedAt',
        // 'id',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'dateNaissance' => 'date',
    ];

    /* ------------------- Relations ------------------- */

    // Un étudiant appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Un étudiant appartient à un utilisateur (auth)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un étudiant a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Un étudiant a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
