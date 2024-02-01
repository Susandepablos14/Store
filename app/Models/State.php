<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function client()
    {
        return $this->hasMany(Client::class,'state_id','id');
    }

    Public Function scopeFilter ($query, $request) {

    return $query->when($request->name, function ($state, $name){
            return $state->where('name',$name);}
    );
    }
}
