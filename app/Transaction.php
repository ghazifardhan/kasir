<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /*
     * @Author: Ghazi Fadil Ramadhan
     */

    public $incrementing = false;

    protected $table = 'transaction';

    protected $fillable = [
      'kode_transaction', 'kode_menu', 'qty', 'price', 'created_by', 'updated_by'
    ];

    public function menu(){
      return $this->hasOne('App\Menu', 'kode_menu', 'kode_menu');
    }
}
