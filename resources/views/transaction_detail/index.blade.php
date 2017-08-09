@extends('layouts.app')
@section('title')
{{ $title }}
@stop
@section('breadcrumb')
{!! Breadcrumbs::render('transaction_detail') !!}
@stop
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h2 class="box-title">{{ $title }}</h2>
            <br>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="myTable" class="table table-bordered table-hover table-striped table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Total Harga</th>
                  <th>Uang Pembeli</th>
                  <th>Kembalian</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1 @endphp
              @foreach($details as $detail)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $detail->kode_transaction }}</td>
                <td>{{ "Rp " . number_format($detail->total_price, 0,',','.') }}</td>
                <td>{{ "Rp " . number_format($detail->customer_cash, 0,',','.') }}</td>
                <td>{{ "Rp " . number_format($detail->customer_change, 0,',','.') }}</td>
                <td>{{ $detail->created_at }}</td>
                <td><a class="btn btn-warning" href="{{ route('transaction_detail.show_transaction', $detail->kode_transaction) }}">Show</a></td>
              </tr>
              @endforeach
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop
@section('script')
<script>
$(document).ready( function () {

  $('#myTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });

});
</script>
@endsection
