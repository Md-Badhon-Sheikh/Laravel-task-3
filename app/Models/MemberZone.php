<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Division;
use App\Models\Zilla;
use App\Models\MemberZoneType;

class MemberZone extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'divisions';


    public function zilla()
    {
        return $this->belongsTo(Zilla::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function memberZoneType()
    {
        return $this->belongsTo(MemberZoneType::class, 'type_id');
    }
}
