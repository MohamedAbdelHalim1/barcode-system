<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $fillable = ['title', 'sku', 'size_id', 'price','store_id'];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
