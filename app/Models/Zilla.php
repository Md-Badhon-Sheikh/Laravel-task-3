<?php

namespace App\Models;

use App\Models\Division;
use App\Models\MemberZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zilla extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'zillas';
    // protected $fillable = ['name_en', 'name_bn', 'priority', 'division', 'created_by'];
    protected $fillable = ['division_id', 'name_en', 'name_bn', 'priority', 'created_by'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

     public function memberZone()
    {
        return $this->hasMany(MemberZone::class);
    }
}
