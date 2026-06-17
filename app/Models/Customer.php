<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'name',
        'since',
        'revenue'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
