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
  #snackbar {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
  }

  #snackbar.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
  }

  @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
  }

  @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
  }

  @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
  }

  @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
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
                  <!--
                  <tr>
                    <th>PPN 10%</th>
                    <td>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox" id="checkbox-ppn">
                        </span>
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="ppn" class='form-control ppn' pattern="[0-9]+([\.,][0-9]+)?" title="Hanya angka" readonly="readonly">
                      </div>
                    </td>
                  </tr>
                -->
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
  </section>

  <div id="snackbar"></div>

</div>
@stop
@section('script')
<script>

var x = 0;
var kode_menu = new Array();
var nama_menu = new Array();
var qty_menu = new Array();
var price_menu = new Array();
var customer_cash;
var customer_change;
var item_price;
var total_price;
var ppn;

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
  total_price = price_menu.reduce(getSum);

  //reset form
  $('.kode_menu').val('').trigger('change');
  $('.menu').val("");
  $('.qty').val("");
});

$('.insert').on('click', function(){
  $.ajax({
    type: 'POST',
    url: '{{ url("/api/test_json") }}',
    data: {kd_menu: kode_menu, nama: nama_menu, qty: qty_menu, price: price_menu, total_price: total_price, customer_cash: customer_cash, customer_change: customer_change, ppn: 0},
    success: function(resp, xhr){
      if(resp.success){
        clearAllData();
        showToast(resp.result);
        console.log(resp.result);
      } else {
        showToast(resp.result);
        console.log(resp.result);
      }
    },
    error: function(xhr){
      showToast('Transaksi gagal, mohon cek kembali');
    }
  });
});

function showToast(text){
    $('#snackbar').text(text);
    var x = document.getElementById("snackbar")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

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
      customer_cash = $(this).val().replace(",","");
      if(price_menu.length == 0){
          $('.customer-change').val(0);
      } else {
        customer_change = customer_cash - total_price;
        if(customer_change < 0){
          $('.customer-change').val("0");
        } else {
          var m = customer_change.toString().replace(/\D/g, '')
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          $('.customer-change').val(m);
        }
      }

      return value
          .replace(/\D/g, '')
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
  });
});

$('#checkbox-ppn').change(function(){
  if(document.getElementById("checkbox-ppn").checked){
    if(price_menu == 0){
      ppn = 0;
      $('.ppn').val(ppn.toString().replace(/\D/g, '')
      .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    } else {
      ppn = (price_menu.reduce(getSum)*10)/100;
      $('.ppn').val(ppn.toString().replace(/\D/g, '')
      .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
  } else {
    ppn = 0;
    $('.ppn').val(ppn.toString().replace(/\D/g, '')
    .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
});

function clearAllData(){
  var jml_arr = price_menu.length;
    console.log(jml_arr);
  for(var a=0;a<jml_arr;a++){
    $('.row' + a).remove();
    delete kode_menu.pop(x)
    delete nama_menu.pop(x)
    delete qty_menu.pop(x)
    delete price_menu.pop(x)
  }
  customer_cash = 0;
  customer_change = 0;
  item_price = 0;
  total_price = 0;
  ppn = 0;
  x = 0;
  $('.customer-cash').val(0);
  $('.customer-change').val(0);
  $('.total').text("Rp 0");
}

</script>
@endsection
