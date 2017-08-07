<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Menu;
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
      $menus = Menu::all();
      return view('transaction.index', compact("title", "menus"));
    }

    public function store(Request $request){
      return response($request->input());
    }
}
