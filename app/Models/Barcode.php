<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $fillable = ['title', 'sku', 'price','store_id'];


    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
