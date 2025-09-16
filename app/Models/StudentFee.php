<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'fee_id',
        'paid_amount',
        'status',
        'payment_date',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
