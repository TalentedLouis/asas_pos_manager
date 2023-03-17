<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptConfig extends Model
{
    use HasFactory, SoftDeletes;

    // public function shop()
    // {
    //     return $this->belongsTo(Shop::class);
    // }
}
