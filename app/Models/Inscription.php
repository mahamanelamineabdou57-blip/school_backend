<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    // Table associée (par défaut : "inscriptions")
    protected $table = 'inscriptions';

    // Champs remplissables en masse
    protected $fillable = [
        'etudiant_id',
        'section_id',
        'inscription_date',
        'status',
        'academic_year_id',
    ];

    /**
     * 🔗 Relations
     */

    // Une inscription appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Une inscription appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Une inscription est liée à une année académique
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
