@extends('layouts.app')
@section('title')
{{ $title }}
@stop
@section('breadcrumb')
{!! Breadcrumbs::render('transaction_detail.show', $id) !!}
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
                  <th>Kode Menu</th>
                  <th>Menu</th>
                  <th>Qty</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1 @endphp
              @foreach($trans as $item)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->kode_menu }}</td>
                <td>{{ $item->menu->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ "Rp " . number_format($item->price, 0,',','.') }}</td>
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
