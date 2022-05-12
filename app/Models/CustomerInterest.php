<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInterest extends Model
{
    use HasFactory;
    protected $table = 'customers_interests';
    public $timestamps = false;
}
