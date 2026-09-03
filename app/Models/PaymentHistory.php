<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_fee_id',
        'etudiant_id',
        'montant_verse',
        'mode_paiement',
        'reference',
        'note',
        'enregistre_par',
    ];

    protected $casts = [
        'montant_verse' => 'decimal:2',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // --- Relations ---

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function enregistrePar()
    {
        return $this->belongsTo(User::class, 'enregistre_par');
    }
}
