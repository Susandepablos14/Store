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
}
