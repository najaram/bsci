<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'products';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'tax'
    ];
}
