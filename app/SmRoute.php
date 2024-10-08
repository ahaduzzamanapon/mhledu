<?php

namespace App;


use App\Scopes\ActiveStatusSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmRoute extends Model
{
    use HasFactory;
    protected $casts = [
        'id'    => 'integer',
        'title' => 'string',
        'far' => 'float'
    ];
    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new ActiveStatusSchoolScope);
    }
   
}
