<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_pt',
        'name_ar',
        'parent_id',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allActiveChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('allActiveChildren', function ($query) {
            $query->where('status', 1);
        })->where('status', 1);
    }

    public function customers_interests()
    {
        return $this->belongsToMany(Customer::class, 'customers_interests');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
