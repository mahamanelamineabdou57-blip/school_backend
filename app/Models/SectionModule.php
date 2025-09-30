<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionModule extends Model
{
    use HasFactory;
   use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'section_id',
        'module_id',
    ];

    /* ---------------- Relations ---------------- */

    // SectionModule appartient à une section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // SectionModule appartient à un module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
