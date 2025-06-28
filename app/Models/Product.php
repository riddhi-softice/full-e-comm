<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
  
    public function firstImage()  // related product
    {
        return $this->hasOne(ProductImage::class)->oldest(); // or ->orderBy('id')
    }

    
}

