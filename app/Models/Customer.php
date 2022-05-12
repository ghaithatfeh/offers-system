<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function customers_interests()
    {
        return $this->belongsToMany(Category::class, 'customers_interests');
    }
}
