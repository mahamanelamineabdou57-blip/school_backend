<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_fee_id',
        'date_relance',
        'canal',
        'statut',
        'message',
    ];

    protected $casts = [
        'date_relance' => 'date',
    ];

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }

    // Raccourcis pratiques (délèguent à la facture liée)
    public function etudiant()
    {
        return $this->hasOneThrough(
            Etudiant::class,
            StudentFee::class,
            'id',            // clé locale sur student_fees
            'id',             // clé locale sur etudiants
            'student_fee_id', // clé étrangère sur payment_reminders
            'etudiant_id'     // clé étrangère sur student_fees
        );
    }
}