@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        <span class="text-capitalize">Affiliate Reports</span>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li class="active">Affiliate Reports</li>
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
            <div class="box-header with-border">
                <div id="datatable_button_stack" class="pull-right text-right"> 
                </div>
            </div>
            {!! csrf_field() !!}
            <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
            <div class="box-body table-responsive">
                <table id="affiliateReportsTable" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th>Affiliate Name</th>
                            <th>Affiliate Commission (%)</th>
                            <th>Date</th>
                            <th>Camp</th>
                            <th>Commission For This Referral ($)</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tfoot align="right">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total Due = $ <span id="totaldue">{{ $getDueAmount }}</span></th>
                            <th>Total Paid = $ <span id="totalpaid">{{ $getPaidAmount }}</span></th>
                        </tr>
                    </tfoot>                   
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

<script src="{{ asset('public/packages/datatableexporttools/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/buttons.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/packages/datatableexporttools/buttons.colVis.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        
        var base_url = $('#base_url').val(); 
        var token = $('input[name="_token"]').val();
        $('title').html("Affiliate Report");
            var dtButtons = function(buttons){
                var extended = [];
                for(var i = 0; i < buttons.length; i++){
                    var item = {
                        extend: buttons[i],
                        footer: true,
                        exportOptions: {
                            columns: [':visible'],
                            format: {
                                body: function( data, row, col, node ) {
                                    // To resolve export issue (All options in export) for Payment Status column
                                    if (col == 4) {
                                        return table
                                        .cell( {row: row, column: col} )
                                        .nodes()
                                        .to$()
                                        .find(':selected')
                                        .text()
                                    } else {
                                        return data;
                                    }
                                }
                            }
                        }
                    };
                    switch(buttons[i]){
                       case 'pdfHtml5':
                       item.orientation = 'landscape';
                       break;
                    }
                    extended.push(item);
                }
                return extended;
            }
        var table = $('#affiliateReportsTable').DataTable({
            processing: true,
            language: {
                 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
            },
            serverSide: false,
            ajax: {
                "url": base_url+"/admin/getAffiliateReportList",
                headers: {'X-CSRF-TOKEN': token},
                "type": "POST"
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'commission_percentage', name: 'commission_percentage' },
                { data: 'created_at', name: 'created_at' },
                { data: 'camp_focus', name: 'camp_focus' },
                { data: 'amount', name: 'amount' },
                { data: 'is_paid', name: 'is_paid'}
                
            ],
            dom: 'Blfrtip',
            buttons: dtButtons([
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'colvis'
            ])
        });

        // move the datatable buttons in the top-right corner and make them smaller
        table.buttons().each(function(button) {
            if (button.node.className.indexOf('buttons-columnVisibility') == -1) {
               button.node.className = button.node.className + " btn-sm";
            }
        });
        $(".dt-buttons").appendTo($('#datatable_button_stack' ));
    });

    //is approve enable function start
    function changePaymentStatus(id) {
        if (!confirm("Are you sure you want to change the payment status?")) {
           location.reload();
        } else {
            var base_url = $('#base_url').val(); 
            var token = $('input[name="_token"]').val();
            var paymentStatus = $("#change-payment-"+id).val();
            var commissionAmount = parseFloat($("#change-payment-"+id).closest('td').prev('td').text());
            var currentDue;
            var currentPaid;
            $.ajax({
                url:base_url+"/admin/ajaxAffiliatePaymentStatus",
                type:"POST",
                data:{"_token":token,"id":id,"paymentStatus":paymentStatus},
                success:function(res) {
                    currentDue = parseFloat($('#totaldue').text());
                    currentPaid = parseFloat($('#totalpaid').text());
                    if (paymentStatus == '1') {
                        dueTotal = currentDue - commissionAmount;
                        paidTotal = currentPaid + commissionAmount;
                    } else {
                        dueTotal = currentDue + commissionAmount;
                        paidTotal = currentPaid - commissionAmount;
                    }
                    $('#totaldue').text(parseFloat(dueTotal).toFixed(2));
                    $('#totalpaid').text(parseFloat(paidTotal).toFixed(2));
                }
            });
        }
        
    }
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection