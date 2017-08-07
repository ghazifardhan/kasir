<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /*
     * @Author: Ghazi Fadil Ramadhan
     */
    public $primaryKey  = 'kode_menu';

    public $incrementing = false;

    protected $table = 'menu';

    protected $fillable = [
      'kode_menu', 'name', 'price', 'created_by', 'updated_by'
    ];

    public $validate = [
      'kode_menu' => 'unique:menu|required',
      'name' => 'required',
      'price' => 'required'
    ];

}
