<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'brand_id',
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function clothe()
    {
        return $this->hasMany(Clothe::class,'product_id','id');
    }

    public function scopeFilter($query, $request)
    {
        return $query->when($request->name, function ($brands, $name){
            return $brands->where('name', $name);
        })->when($request->description, function ($brands, $description){
            return $brands->where('description', $description);
        })->when($request->price, function ($brands, $price){
            return $brands->where('price', $price);
        })->when($request->stock, function ($brands, $stock){
            return $brands->where('stock', $stock);
        })->when($request->brand_id, function ($brands, $brand_id){
            return $brands->where('brand_id', $brand_id);
        }
    );
    }
}
