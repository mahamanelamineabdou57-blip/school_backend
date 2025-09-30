<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
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
