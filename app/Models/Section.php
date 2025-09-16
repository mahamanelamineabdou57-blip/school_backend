<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'departement_id',
    ];

    /* ---------------- Relations ---------------- */

    // Une section appartient à un département
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    // Une section a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Une section a plusieurs modules (via pivot ou relation directe)
    public function sectionModules()
    {
        return $this->hasMany(SectionModule::class);
    }

    // Une section a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Une section a plusieurs étudiants
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
