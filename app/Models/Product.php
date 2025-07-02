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

    public function category() {
        // return $this->belongsTo(Category::class,'cat_id');
        return $this->belongsTo(Category::class,'cat_id')->withDefault(['name'=> 'N/A']);       
        // return $this->belongsTo(Category::class, 'cat_id')->withDefault([
        //     'name' => 'N/A'
        // ]);
    }

    public function subCategory(){

        return $this->belongsTo(subCategory::class,'sub_cat_id')->withDefault(['name'=>"N/A"]);
        // return $this->belongsTo(SubCategory::class,'sub_cat_id');
    }

    public function brand() {

        return $this->belongsTo(Brand::class,'brand_id')->withDefault(['name'=>"N/A"]);
        // return $this->belongsTo(Brand::class,'brand_id');
    }

    public function attributeValues() {
        return $this->hasMany(AttributeValue::class,'product_id');
        // return $this->hasMany(AttributeValue::class,'product_id');
    }
}