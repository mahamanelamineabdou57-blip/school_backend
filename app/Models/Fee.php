<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory;
    use SoftDeletes;
//     export interface Paiement {
//   id: number;
//   inscriptionId: number;
//   type: 'inscription' | 'formation';
//   montant: number;
//   datePaiement?: Date;
//   statut: 'non payé' | 'partiellement payé' | 'payé';
//   createdAt?: Date;
//   updatedAt?: Date;
//   deletedAt?: Date | null;
// }
 

    protected $dates = ['deleted_at'];
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
}
