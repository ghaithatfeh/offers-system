<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetArea extends Model
{
    use HasFactory;
    protected $primaryKey = 'offer_id';
    protected $fillable = ['offer_id', 'city_id'];
}
