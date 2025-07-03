<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Division;

class Zilla extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'zillas';
    // protected $fillable = ['name_en', 'name_bn', 'priority', 'division', 'created_by'];
    protected $fillable = ['division_id', 'name_en'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
