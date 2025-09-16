<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées en mass assignment
     */
    protected $fillable = [
        'name',
        'faculte_id',
    ];

    /* ---------------- Relations ---------------- */

    // Un département appartient à une faculté
    public function faculte()
    {
        return $this->belongsTo(Faculte::class);
    }

    // Un département possède plusieurs sections
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
