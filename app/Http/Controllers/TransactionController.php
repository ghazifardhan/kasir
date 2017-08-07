<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Redirect;
use Validator;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct(){
      $this->transaction = new Transaction();
      $this->middleware('auth');
    }

    public function index(){
      $title = "Create Transaction";
      return view('transaction.index', compact("title"));
    }

    public function store(Request $request){
      return response($request->input());
    }
}
