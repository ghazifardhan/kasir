@extends('layouts.app')
@section('title')
{{ $title }}
@stop
@section('style')
<style>
  input {
    border: none;
    background-color: transparent;
  }
</style>
@stop
@section('breadcrumb')
{!! Breadcrumbs::render('transaction') !!}
@stop
@section('content')
<div class="container">
  <section class="content">
    <div class="row">
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Transaksi</h3>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Kode Menu</label>
              <select class="form-control select2 kode_menu"style="width: 100%">
                <option></option>
              @foreach($menus as $menu)
                <option value="{{ $menu->kode_menu }}">{{ $menu->kode_menu." - ".$menu->name." - ".$menu->price }}</option>
              @endforeach
              </select>
              <input type="hidden" class="form-control menu">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Qty</label>
              <input type="text" class="form-control qty" placeholder="Enter Quantity">
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary submit">Submit</button>
          </div>
        </div>
      </div>

      <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h2 class="pull-left">Total</h2>
              <h2 class="pull-right total">Rp 0</h2>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!--{!! Form::model(new App\Transaction, ['class' => 'form-horizontal', 'route' => 'transaction.store']) !!}-->
              <div class="box-body">
                <table class="table table-hover">
                  <thead>
                    <th>Kode Menu</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Action</th>
                  </thead>
                  <tbody id="table">
                  </tbody>
                </table>
                <table class="table table-bordered">
                  <tr>
                    <th>Uang Customer</th>
                    <td>
                      <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="price" class='form-control customer-cash' pattern="[0-9]+([\.,][0-9]+)?" title="Hanya angka">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Kembalian</th>
                    <td>
                      <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="price" class='form-control customer-change' pattern="[0-9]+([\.,][0-9]+)?" title="Hanya angka" readonly="readonly">
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-left insert">Proses</button>
              </div>
              <!-- /.box-footer -->
            <!--{!! Form::close() !!}-->
          </div>
    </div>
</div>
@stop
@section('script')
<script>

var x = 0;
var kode_menu = new Array();
var nama_menu = new Array();
var qty_menu = new Array();
var price_menu = new Array();
var item_price;
$('.kode_menu').change(function(){
  $.ajax({
    type: 'GET',
    url: '{{ url("/api/get_item_data") }}' + "/" + $('.kode_menu').val(),
    success: function(resp){
      $('.menu').val(resp.result.name);
      item_price = resp.result.price;
    }
  })
});

$('.submit').on('click', function(){
  var k_menu = $('.kode_menu').val();
  var name = $('.menu').val();
  var qty = $('.qty').val();
  var price = qty * item_price;
  kode_menu.push(k_menu);
  nama_menu.push(name);
  qty_menu.push(qty);
  price_menu.push(price);
  $('#table').append("<tr class='row"+x+"'>"
  + "<td class='kode_menu"+x+"'>"+ k_menu +"</td>"
  + "<td class='nama"+x+"'>"+ name +"</td>"
  + "<td class='qty"+x+"'>"+ qty +"</td>"
  + "<td class='price"+x+"'>"+ price.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",") +"</td>"
  + "<td><button class='btn btn-danger' onclick='hapus("+x+")'>Delete</button></td>"
  + "</tr>");
  x++;

  //total
  $('.total').text("Rp " + price_menu.reduce(getSum).toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ","));

  //reset form
  $('.kode_menu').val('').trigger('change');
  $('.menu').val("");
  $('.qty').val("");
});

$('.insert').on('click', function(){
  $.ajax({
    type: 'POST',
    url: '{{ url("/api/test_json") }}',
    data: {kd_menu: kode_menu, nama: nama_menu, qty: qty_menu, price: price_menu},
    success: function(resp){
      console.log(resp);
    }
  });
});

function hapus(x){
  delete kode_menu.pop(x);
  delete nama_menu.pop(x);
  delete qty_menu.pop(x);
  delete price_menu.pop(x);
  $('.row' + x).remove();
  if(price_menu.length == 0){
    $('.total').text("Rp 0");
  } else {
    $('.total').text("Rp " + price_menu.reduce(getSum).toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
  x--;
}

function getSum(total, num){
  return total + num;
}

$('.select2').select2({
  placeholder: "Select a menu",
  allowClear: true
});

$('input.customer-cash').keyup(function(event) {
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40){
      event.preventDefault();
  }

  $(this).val(function(index, value) {
      var cash = $(this).val().replace(",","");
      var change;
      if(price_menu.length == 0){
          $('.customer-change').val(0);
      } else {
        change = cash - price_menu.reduce(getSum);
        var m = change.toString().replace(/\D/g, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.customer-change').val(m);
      }

      return value
          .replace(/\D/g, '')
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
  });
});

</script>
@endsection
