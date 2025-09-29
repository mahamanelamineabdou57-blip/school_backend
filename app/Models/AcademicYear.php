<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées au remplissage de masse
     */
    protected $fillable = [
        'nom',
        'actif',
        'description',
    ];

    /**
     * Casts automatiques
     */

    /* ---------------- Relations ---------------- */

    // Une année académique a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Une année académique a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
