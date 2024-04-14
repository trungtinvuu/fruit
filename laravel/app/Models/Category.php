<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'root_id',
        'parent_id',
        'level',
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->childs()->delete();
        });
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d \a\t g:i a');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d \a\t g:i a');
    }
}
