<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
    ];

    Public Function scopeFilter ($query, $request) {

        return $query->when($request->client_id, function ($cart, $client_id){
                return $cart->where('client_id',$client_id);}
        );
        }

}
