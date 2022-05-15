<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    use HasFactory;
    protected $fillable = ['name_en', 'name_pt', 'name_ar', 'status', 'price', 'description'];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
