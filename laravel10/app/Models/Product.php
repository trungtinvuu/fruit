<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'unit',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_details')->withPivot('quantity', 'price');
    }
}
