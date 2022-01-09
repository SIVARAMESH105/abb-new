@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        <span class="text-capitalize">Image Gallery</span>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li class="active">Image Gallery</li>
      </ol>
    </section>
@endsection
<?php //echo 'ds';die; ?>
@section('content')
<!-- Default box -->

<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
        <div class="box">
            {!! csrf_field() !!}
          <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
            <div class="box-body table-responsive">
                <table id="imagesTable" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Image</th>
                            <th>Caption</th>
                        </tr>
                    </thead>                   
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link href="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <!-- DATA TABLES SCRIPT -->
<script src="{{ asset('public/vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/vendor/backpack/crud/js/crud.js') }}"></script>
<script src="{{ asset('public/vendor/backpack/crud/js/form.js') }}"></script>
<script src="{{ asset('public/vendor/backpack/crud/js/list.js') }}"></script>

<script src="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
    var base_url = $('#base_url').val(); 
    var token = $('input[name="_token"]').val();
    $('#imagesTable').DataTable({
        processing: true,
        language: {
             processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
        },
        serverSide: true,
        ajax: {
            "url": base_url+"/admin/getimageslist",
            headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'status', name: 'status', orderable: false },
            { data: 'realname', name: 'realname' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone'},
            { data: 'image', name: 'image', orderable: false },
            { data: 'caption', name: 'caption' }
        ]
    });

    
});
</script>
 <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection