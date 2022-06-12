<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExcelFile extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    public function offers()
    {
        return $this->hasMany(Offer::class, 'excel_id');
    }
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
