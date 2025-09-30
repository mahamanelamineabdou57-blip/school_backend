<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * Colonnes autorisées en mass assignment
     */
    protected $fillable = [
        'nom',
        'faculte_id',
        'code',
    ];

    /* ---------------- Relations ---------------- */

    // Un département appartient à une faculté
    public function facultes()
    {
        return $this->belongsTo(Faculte::class);
    }

    // Un département possède plusieurs sections
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
