<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReceiver extends Model
{
    use HasFactory;
    protected $timestapms = false;
    public $fillable = ['customer_id', 'notification_id'];
}
