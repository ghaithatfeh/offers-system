<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'logo', 'cover', 'description', 'city_id', 'status', 'expiry_date'];

    public function city()
    {
        return $this->belongsTo('citeis');
    }
}
