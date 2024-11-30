<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['key'];

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }
}
