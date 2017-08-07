<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    private $menu;

    public function __construct(){
      $this->menu = new Menu();
      $this->middleware('auth');
    }

    public function index(){
      $menu = $this->menu->all();
      $res['result'] = $menu;
      $title = 'Daftar Menu';
      return view('menu.index', compact('menu', 'res', 'title'));
    }

    public function create(){
      $res['create'] = true;
      $res['status'] = "Create New";
      $menu = null;
      $title = 'Add Menu';
    	return view('menu.form', compact('menu', 'res', 'title'));
    }

    public function store(Request $request){
      Validator::validate($request->input(), $this->menu->validate);
      $this->menu->fill([
        'kode_menu' => $request->input('kode_menu'),
        'name' => $request->input('name'),
        'price' => str_replace(",","",$request->input('price')),
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
      ]);
      if($this->menu->save()){
        $res['success'] = true;
        $res['result'] = 'Success add menu';
      } else {
        $res['success'] = false;
        $res['result'] = 'Failed add menu';
      }
      return Redirect::route('menu.index');
    }

    public function edit($id){
      $menu = $this->menu->where('kode_menu', $id)->first();
      $res['create'] = false;
      $res['status'] = "Update";
      $title = 'Edit Karyawan - ' . $menu->name;
      return view('menu.form', compact('menu', 'res', 'title'));
    }

    public function update(Request $request, $id){
      $menu = $this->menu->where('kode_menu', $id)->first();
      $menu->kode_menu = $request->input('kode_menu');
      $menu->name = $request->input('name');
      $menu->price = $request->input('price');
      $menu->updated_by = Auth::id();
      $menu->save();
      return Redirect::route('menu.index');
    }

    public function show($id){
      $menu = $this->menu->find($id);
      $title = $menu->name;
      return view('menu.show', compact('menu', 'title'));
    }

    public function destroy($id){
      $menu = $this->menu->find($id);
      $menu->delete();
      return Redirect::route('menu.index');
    }
}
