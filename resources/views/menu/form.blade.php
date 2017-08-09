@extends('layouts.app')
@section('title')
{{ $title }}
@stop
@section('breadcrumb')
@if($res['create'])
{!! Breadcrumbs::render('menu.create') !!}
@else
{!! Breadcrumbs::render('menu.edit', $menu) !!}
@endif
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $res['status'] }} Menu</div>

                <div class="panel-body">

                  @if($errors->any())
                      <div class="flash alert-danger">
                          @foreach($errors->all() as $error)
                          <p>{{ $error }}</p>
                          @endforeach
                      </div>
                  @endif
                          <table class='table table-hover table-responsive table-bordered'>
                          <?php if($res['create']){ ?>
                          {!! Form::model(new App\Menu, ['class' => 'form-horizontal', 'route' => 'menu.store']) !!}
                          <?php } else { ?>
                          {!! Form::model($menu, ['method' => 'PATCH', 'route' => ['menu.update', $menu->kode_menu], 'class' => 'form-horizontal']) !!}
                          <?php } ?>
                              <tr>
                                  <td>Kode Menu</td>
                                  <td>
                                    <div id="check-kode">
                                      <input type="text" name="kode_menu" class='form-control' value="<?php if($menu){echo $menu->kode_menu;} ?>">
                                      <span class="help-block"></span>
                                    </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Nama Menu</td>
                                  <td><input type="text" name="name" class='form-control' value="<?php if($menu){echo $menu->name;} ?>"></td>
                              </tr>
                              <tr>
                                  <td>Price</td>
                                  <td>
                                      <div class="input-group">
                                        <span class="input-group-addon">Rp</span><input type="text" name="price" class='form-control number' pattern="[0-9]+([\.,][0-9]+)?" title="Hanya angka" value="<?php if($menu){echo $menu->price;} ?>">
                                      </div>
                                    </td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td>{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                      <input type="reset" class="btn btn-warning" value="Reset">
                          {!! Form::close() !!}
                              </tr>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>

//Date picker
    $('#datepicker').datepicker();
    $('#datepicker').datepicker({
      'dateFormat': 'yy-mm-dd'
    })

    $('input.number').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }

      $(this).val(function(index, value) {
          return value
              .replace(/\D/g, '')
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          ;
      });
    });

    var d = document.getElementById("check-kode");

    $('input[name="kode_menu"]').keyup(function(event){
      // get keycode of current keypress event
      var code = (event.keyCode || event.which);
      // do nothing if it's an arrow key
      if(code == 37 || code == 38 || code == 39 || code == 40) {
          return;
      }
      $(this).val(function(index, value){
        if(value == ""){
          d.className = "";
          $('.help-block').text("");
        } else {
          $.ajax({
            type: 'POST',
            url: '{{ url("/api/check_kode_menu") }}',
            data: {kode_menu: value},
            success: function(resp){
              if(resp.success){
                d.className = "has-success";
                $('.help-block').text(resp.result);
              } else {
                d.className = "has-error";
                $('.help-block').text(resp.result);
              }
            }
          });
        }
        return value;
      });
    });

</script>
@stop
@endsection
