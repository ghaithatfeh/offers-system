<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo', 'cover', 'description', 'city_id', 'user_id', 'status', 'expiry_date'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'subscriptions');
    }
}
