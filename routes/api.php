<?php

use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;
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

  date_default_timezone_set('Asia/Jakarta');
  $date = date('Ymdhis');
  $jml_arr = count($request->input('kd_menu'));
  $kd_menu = $request->input('kd_menu');
  $nama = $request->input('nama');
  $qty = $request->input('qty');
  $price = $request->input('price');
  for($x=0;$x<$jml_arr;$x++){
    $trans[$x] = new Transaction();
    $trans[$x]->fill([
      'kode_transaction' => 'trans'.$date,
      'kode_menu' => $kd_menu[$x],
      'qty' => $qty[$x],
      'price' => $price[$x],
      'created_by' => '1',
      'updated_by' => '1',
    ]);
    $trans[$x]->save();
  }
  $trans_detail = new TransactionDetail();
  $trans_detail->fill([
    'kode_transaction' => 'trans'.$date,
    'total_price' => $request->input('total_price'),
    'customer_cash' => $request->input('customer_cash'),
    'customer_change' => $request->input('customer_change'),
    'ppn' => $request->input('ppn'),
    'created_by' => '1',
    'updated_by' => '1',
  ]);
  if($trans_detail->save()){
    $res['success'] = true;
    $res['result'] = "Transaksi Berhasil.";
  } else {
    $res['success'] = true;
    $res['result'] = "Transaksi Berhasil.";
  }

  return response($res);
});

Route::get('/get_item_data/{id}', function(Request $request, $id){
  $menu = Menu::where('kode_menu', $id)->first();
  $res['result'] = $menu;
  return response($res);
});
