<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Builder\Function_;

class Detailcart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    Public Function scopeFilter ($query, $request){

    return $query->when($request->cart_id, function ($detailcarts, $cart_id){
            return $detailcarts->where('cart_id',$cart_id);}
    )->when($request->product_id, function ($detailcarts, $product_id){
            return $detailcarts->where('product_id', $product_id);}
    )->when($request->quantity, function ($detailcarts, $quantity){
            return $detailcarts->where('quantity', $quantity);}
    );
    }
}
