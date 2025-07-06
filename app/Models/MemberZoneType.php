<?php

namespace App\Models;

use App\Models\MemberZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberZoneType extends Model
{
    use HasFactory;
     protected $guarded = [];
     protected $table = 'member_zone_types';

      public function memberZone()
    {
        return $this->hasMany(MemberZone::class);
    }
}

