<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inteface extends Model
{
    use HasFactory;
    protected $table = 'intefaces';
    protected $fillable = [
        'nom',
    ];

    public function acces()
    {
        return $this->hasMany(Acces::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
