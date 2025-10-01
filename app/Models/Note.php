<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'noteSessionNormale',
        'noteRattrapage',
        'inscriptionId',
        'ecueId',
    ];

    protected $casts = [
        'noteSessionNormale' => 'decimal:2',
        'noteRattrapage' => 'decimal:2',
    ];

    /* ---------------- Relations ---------------- */

    // Note appartient à un étudiant
    public function inscriptions()
    {
        return $this->belongsTo(Inscription::class, 'inscriptionId');
    }

    // Note appartient à un module (ECUE)
    public function ecue()
    {
        return $this->belongsTo(Module::class, 'ecueId');
    }
}
