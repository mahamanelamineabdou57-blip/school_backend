<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acces extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'acces';
    protected $fillable = [
        'droits',
        'inteface_id',
        'utilisateur_id',
    ];
    public function inteface()
    {
        return $this->belongsTo(Inteface::class, 'inteface_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
