<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Footwear extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'size',
        'color',
        'material',
        'url',
        'product_id'];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    Public function scopeFilter ($query, $request){
        return $query->when($request->type, Function ($Footwears, $type){
            return $Footwears->where('type', $type);
        })->when($request->size, Function ($Footwears, $size){
            return $Footwears->where('size', $size);
        })->when($request->color, Function ($Footwears, $color){
            return $Footwears->where('color', $color);
        })->when($request->material, Function ($Footwears, $material){
            return $Footwears->where('material', $material);
        })->when($request->url, Function ($Footwears, $url){
            return $Footwears->where('url', $url);
        })->when($request->product_id, Function ($Footwears, $product_id){
            return $Footwears->where('product_id', $product_id);
        });
    }
}
