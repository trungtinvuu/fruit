<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory; 

    protected $fillable = [
        'customer_name'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_details')->withPivot('quantity');
    }
}
