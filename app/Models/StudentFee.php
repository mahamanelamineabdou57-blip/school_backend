<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'etudiant_id',
        'inscription_id',
        'fee_type_id',
        'montant_du',
        'paid_amount',
        'status',
        'payment_date',
    ];

    protected $casts = [
        'montant_du'   => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class);
    }

    public function paymentReminders()
    {
        return $this->hasMany(PaymentReminder::class);
    }

    public function getResteAPayerAttribute(): float
    {
        return max(0, (float) $this->montant_du - (float) $this->paid_amount);
    }
}