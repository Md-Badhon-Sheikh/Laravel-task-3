<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
