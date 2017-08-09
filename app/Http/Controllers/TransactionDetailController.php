<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Transaction;
use App\TransactionDetail;
use APp\Menu;

class TransactionDetailController extends Controller
{
    var $detail;

    public function __construct(){
      $this->detail = new TransactionDetail();
      $this->middleware('auth');
    }

    public function index(){
      $details = $this->detail->orderBy('created_at', 'desc')->get();
      $title = 'Daftar Transaksi';
      return view('transaction_detail.index', compact('details', 'title'));
    }

    public function showTransaction($id){
      $title = 'Show ' . $id;
      $trans = Transaction::where('kode_transaction', $id)->with('menu')->get();
      return view('transaction_detail.show', compact('title', 'trans', 'id'));
    }
}
