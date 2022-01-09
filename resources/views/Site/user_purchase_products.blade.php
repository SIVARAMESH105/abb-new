@include("Site.header")
<div class="secondary-top">
	@if (session('status'))          
	<div class="alert alert-success">  
	<a class="panel-close close" data-dismiss="alert">&times;</a>                
	{{ session('status') }}
	</div>
	@endif
	@if (session('error'))
		<div class="alert alert-danger removeonajax">
		<a class="panel-close close" data-dismiss="alert">&times;</a>  
			{{ session('error') }}
		</div>
	@endif
    <div class="container container-md search-content">
        <div class="bg-white-section">
            <div class="row">
                <div class="col-xs-12">
                    <div><h2>Purchase Products</h2></div>
                    &nbsp;
                    {!! csrf_field() !!}
                    <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
					<div class="table-responsive">
						<table class="table table-bordered responsive purchase-datatable" id="users-table">
							<thead>
								<tr>
									<th>Order Id</th>
									<th>Order Date</th>
									<th>Product Name</th>
									<th>Category</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Size</th>
									<th>Color</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
                </div>
            </div>
        </div>    
    </div>
</div>
@include("Site.features")
@include("Site.footer")
 

  <!-- DataTables -->
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<!-- Bootstrap JavaScript -->
<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	var base_url = $('#base_url').val(); 
	var token = $('input[name="_token"]').val();
    $('#users-table').DataTable({
    	
        processing: true,
		language: {
			 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
		},
        serverSide: true,
		ajax: {
            "url": base_url+"/user/getPurchaseProductslist",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'od_id', name: 'od_id' },
            { data: 'od_date', name: 'od_date' },
            { data: 'pd_name', name: 'pd_name' },
            { data: 'pd_category', name: 'startdate' },
            { data: 'od_wa_cost', name: 'od_wa_cost' },
            { data: 'od_qty', name: 'od_qty' },
            { data: 'od_size', name: 'od_size' },
            { data: 'od_color', name: 'od_color' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<script>
	setTimeout(function() {
	 $('.alert-success').fadeOut();
	 $('#name, #email, #msg, #origin').val('')
	}, 5000 );
</script>

<?php //echo 'fd';die; ?>

