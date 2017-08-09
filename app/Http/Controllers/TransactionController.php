<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;
use App\Menu;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct(){
      $this->transaction = new Transaction();
      $this->middleware('auth');
    }

    public function index(){
      $title = "Create Transaction";
      $menus = Menu::all();
      return view('transaction.index', compact("title", "menus"));
    }

    public function store(Request $request){
      return response($request->input());
    }

    public function storeTransaction(Request $request){
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
          'created_by' => Auth::id(),
          'updated_by' => Auth::id(),
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
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
      ]);
      if($trans_detail->save()){
        $res['success'] = true;
        $res['result'] = "Transaksi Berhasil.";
      } else {
        $res['success'] = true;
        $res['result'] = "Transaksi Berhasil.";
      }

      return response($res);
    }
}
