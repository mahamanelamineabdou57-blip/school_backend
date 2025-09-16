<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'valeur',
        'etudiant_id',
        'module_id',
        'section_id',
        'academic_year_id',
    ];

    protected $casts = [
        'valeur' => 'decimal:2',
    ];

    /* ---------------- Relations ---------------- */

    // Note appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Note appartient à un module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Note appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Note appartient à une année académique
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
