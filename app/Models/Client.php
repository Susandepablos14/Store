<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'address',
        'state_id',
        'phone',
        'email',
        'ci',
    ] ;

    public function state()
    {
        return $this->hasOne(Client::class,'id','client_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class,'client_id','id');
    }


    Public Function scopeFilter ($query, $request) {

    return $query->when($request->name, function ($clients, $name){
            return $clients->where('name',$name);}
    )->when($request->last_name, function ($clients, $last_name){
            return $clients->where('last_name', $last_name);}
    )->when($request->address, function ($clients, $address){
            return $clients->where('address', $address);}
    )->when($request->state_id, function ($clients, $state_id){
            return $clients->where('state_id', $state_id);}
    )->when($request->phone, function ($clients, $phone){
            return $clients->where('phone', $phone);}
    )->when($request->email, function ($clients, $email){
            return $clients->where('email', $email);}
    )->when($request->ci, function ($clients, $ci){
            return $clients->where('ci', $ci);}
    );
    }
}
