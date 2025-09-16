<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    /**
     * Colonnes qui peuvent être remplies en masse (mass assignment)
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'phone_number',
        'section_id',
        'user_id',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /* ------------------- Relations ------------------- */

    // Un étudiant appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Un étudiant appartient à un utilisateur (auth)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un étudiant a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Un étudiant a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
