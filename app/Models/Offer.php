<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'expiry_date',
        'price',
        'status',
        'description',
        'reject_reason',
        'offer_type_id',
        'category_id',
        'customer_id',
        'user_id',
        'excel_id',
        'reviewed_at',
        'reviewed_by',
    ];
    public function offerType()
    {
        return $this->belongsTo(OfferType::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    public function targetAreas()
    {
        return $this->belongsToMany(City::class, 'target_areas');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'offer_tags');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function excel()
    {
        return $this->belongsTo(ExcelFile::class, 'excel_id');
    }
}
