<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniteEnseignement extends Model
{
    protected $fillable = [
        'name',
        'code',
        'credits',
        'section_id'
    ];



    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
 