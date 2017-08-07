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
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Transaksi</h3>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Kode Menu</label>
              <input type="text" class="form-control menu" placeholder="Enter Kode Menu or Menu">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Qty</label>
              <input type="text" class="form-control qty" placeholder="Enter Quantity">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control price" placeholder="">
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
              <h3 class="box-title">Horizontal Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model(new App\Transaction, ['class' => 'form-horizontal', 'route' => 'transaction.store']) !!}
              <div class="box-body">
                <table class="table table-hover">
                  <thead>
                    <th>Kode Menu</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                  </thead>
                  <tbody id="table">
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-left">Submit</button>
              </div>
              <!-- /.box-footer -->
            {!! Form::close() !!}
          </div>
    </div>
</div>
@stop
@section('script')
<script>

$('.submit').on('click', function(){
  var name = $('.menu').val();
  var qty = $('.qty').val();
  var price = $('.price').val();

  $('#table').append("<tr>"
  + "<td><input type='text' name='kode_menu[]' value='"+ name +"' readonly='readonly'></td>"
  + "<td><input type='text' name='nama[]' value='"+ name +"' readonly='readonly'</td>"
  + "<td><input type='text' name='qty[]' value='"+ qty +"' readonly='readonly'</td>"
  + "<td><input type='text' name='price[]' value='"+ price +"' readonly='readonly'</td>"
  + "</tr>");
});


</script>
@endsection
