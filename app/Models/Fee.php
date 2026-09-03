<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = ['deleted_at' => 'datetime'];
    protected $fillable = [
        'inscriptionId',
        'type',
        'montant',
        'datePaiement',
        'statut',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscriptionId');
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class, 'fee_id');
    }
}
