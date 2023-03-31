<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLine extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = "mysql";

    public function transaction_slip(){
        $this->belongsTo(TransactionSlip::class);
    }
}
