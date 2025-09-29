<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acces extends Model
{
    use HasFactory;
    protected $table = 'acces';
    protected $fillable = [
        'droits',
        'interface_id',
        'utilisateur_id',
    ];
    public function inteface()
    {
        return $this->belongsTo(Inteface::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
