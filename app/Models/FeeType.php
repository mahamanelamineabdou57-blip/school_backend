<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'libelle',
        'montant_defaut',
        'academic_year_id',
        'formation_id',
    ];

    protected $casts = [
        'montant_defaut' => 'decimal:2',
    ];

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}