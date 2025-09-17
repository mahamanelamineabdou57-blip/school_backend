<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'section_module_id',
        'enseignant_id',
        'credits',
        'volume_horaire',
        'unite_id'
    ];

    /* ---------------- Relations ---------------- */

    // Module appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_module_id');
    }

    // Module appartient à un enseignant
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    // Module a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Module a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function unite_enseignements()
    {
        return $this->belongsTo(UniteEnseignement::class);
    }
}
