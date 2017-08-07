<?php

use Illuminate\Http\Request;
use App\Transaction;
use App\Menu;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test_json', function(Request $request){
  $test['kd_menu'] = $request->input('kd_menu');
  $test['nama'] = $request->input('nama');
  $test['qty'] = $request->input('qty');
  $test['price'] = $request->input('price');

  return response($test);
});

Route::get('/get_item_data/{id}', function(Request $request, $id){
  $menu = Menu::where('kode_menu', $id)->first();
  $res['result'] = $menu;
  return response($res);
});
