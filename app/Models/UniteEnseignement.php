<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniteEnseignement extends Model
{
       use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nom',
        'code',
        'credits',
        'formation_id',
    ];



    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }
}
