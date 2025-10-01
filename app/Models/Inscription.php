<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    // Table associée (par défaut : "inscriptions")
    protected $table = 'inscriptions';

    // Champs remplissables en masse
    protected $fillable = [
        'etudiant_id',
        'formation_id',
        'status',
        'semestre_courant',
        'anneeScolaire_id',
    ];

    /**
     * 🔗 Relations
     */

    // Une inscription appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    // Une inscription est liée à une année académique
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'anneeScolaire_id');
    }
    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }
}
