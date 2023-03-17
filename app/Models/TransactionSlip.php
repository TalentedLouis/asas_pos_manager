<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionSlip extends Model
{
    use HasFactory, SoftDeletes;

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
    public function supplier_target(){
        return $this->belongsTo(SupplierTarget::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function entry_exit_target(){
        return $this->belongsTo(EntryExitTarget::class);
    }
    public function transaction_lines(){
        return $this->hasMany(TransactionLine::class);
    }
}
