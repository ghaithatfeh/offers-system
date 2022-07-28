<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTrack extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'device_token', 'entity_type', 'entity_value'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
