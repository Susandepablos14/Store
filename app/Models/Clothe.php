<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clothe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'size',
        'color',
        'material',
        'url',
        'product_id',
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function scopeFilter($query, $request)
    {
        return $query->when($request->type, function ($clothes, $type){
            return $clothes->where('type', $type);
        })->when($request->size, function ($clothes, $size){
            return $clothes->where('size', $size);
        })->when($request->color, function ($clothes, $color){
            return $clothes->where('color', $color);
        })->when($request->material, function ($clothes, $material){
            return $clothes->where('material', $material);
        })->when($request->url, function ($clothes, $url){
            return $clothes->where('url', $url);
        })->when($request->product_id, function ($clothes, $product_id){
            return $clothes->where('product_id', $product_id);}
    );
    }
}


