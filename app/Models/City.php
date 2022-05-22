<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_pt',
        'name_ar',
        'status'
    ];

    public function Customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function Stores()
    {
        return $this->hasMany(Store::class);
    }
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'target_areas');
    }
}
