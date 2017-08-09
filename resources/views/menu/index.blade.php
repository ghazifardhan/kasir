@extends('layouts.app')
@section('title')
{{ $title }}
@stop
@section('active')
{{ 'active' }}
@stop
@section('breadcrumb')
{!! Breadcrumbs::render('menu') !!}
@stop
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h2 class="box-title">Daftar Menu</h2>
            <br><br>
            <a class="btn btn-primary" href="{{ route('menu.create') }}">+ Buat Menu Baru</a>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="myTable" class="table table-bordered table-hover table-striped table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Menu</th>
                  <th>Nama Menu</th>
                  <th>Harga</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1 @endphp
              @foreach($menu as $item)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->kode_menu }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ "Rp " . number_format($item->price, 0,',','.') }}</td>
                <td>
                  {!! link_to_route('menu.edit', 'Edit', array($item->kode_menu), array('class' => 'btn btn-info')) !!}

                  <button class="btn btn-danger delete" data-id="{{ $item->kode_menu }}" data-token="{{ csrf_token() }}">Delete</button>
                </td>
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

  $('.delete').on('click', function(){
    var id = $(this).data('id');
    var token = $(this).data('token');
    $.ajax({
      url: '{{ url('menu') }}/' + id,
      type: 'POST',
      data: {'_method': 'DELETE', '_token':token},
      success: function(){
        console.log('Success Delete!');
        window.location.href = "{{ url('menu') }}";
      }
    });
  });

});
</script>
@endsection
