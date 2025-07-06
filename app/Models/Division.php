<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zilla;
use App\Models\MemberZone;

class Division extends Model
{
    use HasFactory;
    protected $guarded = [];
     protected $table = 'divisions';

      protected $fillable = ['name'];

    public function zillas()
    {
        return $this->hasMany(Zilla::class);
    }
     public function memberZone()
    {
        return $this->hasMany(MemberZone::class);
    }
}
