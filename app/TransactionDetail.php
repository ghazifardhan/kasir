<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_detail';

    public $incrementing = false;

    public $primaryKey  = 'kode_transaction';

    protected $fillable = [
      'kode_transaction',
      'total_price',
      'customer_cash',
      'customer_change',
      'ppn',
      'created_by',
      'updated_by'
    ];

    public function transaction(){
      return $this->hasMany('App\Transaction', 'kode_transaction', 'kode_transaction');
    }
}
