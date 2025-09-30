<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFee extends Model
{
    use HasFactory;
   use SoftDeletes;

    protected $dates = ['deleted_at'];
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
