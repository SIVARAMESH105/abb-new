@include("Site.header")
        <div class="secondary-top">
        	<div class="container container-md">
                <div class="bg-white-section">
					<div class="col-md-12">
						<div><h2>Camp Commission Lists</h2></div>
				        <div class="box">
				            <div class="box-header with-border">
				                <div id="datatable_button_stack" class="pull-right text-right"> 
				                </div>
				            </div>
				            {!! csrf_field() !!}
				            <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
				            <div class="table-responsive">
				                <table id="affiliateReportsTable" class="table table-bordered display">
				                    <thead>
				                        <tr>
				                            
				                            <th>Affiliate Commission (%)</th>
				                            <th>Date</th>
				                            <th>Camp</th>
				                            <th>Commission For This Referral ($)</th>
				                            <th>Payment Status</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                    	<tr>
				                    		<th></th>
				                    		<th></th>
				                    		<th></th>
				                    		<th>Total Due = $ {{ $getDueAmount }}</th>
                            				<th>Total Earnings	 = $ {{ $getPaidAmount }}</th>
				                    	</tr>
				                    </tfoot>
				                </table>
				            </div>
				        </div>
				    </div>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
     <!-- DataTables -->
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <!-- Bootstrap JavaScript -->
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script type="text/javascript">
	    $(document).ready(function() {	        
	        var base_url = $('#base_url').val(); 
	        var token = $('input[name="_token"]').val();
	        var table = $('#affiliateReportsTable').DataTable({
	            processing: true,
	            language: {
	                 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
	            },
	            serverSide: false,
	            ajax: {
	                "url": base_url+"/affiliate/getAffiliateReportList",
	                headers: {'X-CSRF-TOKEN': token},
	                "type": "POST"
	            },
	            columns: [
	                { data: 'commission_percentage', name: 'commission_percentage' },
	                { data: 'created_at', name: 'created_at' },
	                { data: 'camp_focus', name: 'camp_focus' },
	                { data: 'amount', name: 'amount' },
	                { data: 'is_paid', name: 'is_paid'}
	                
	            ]
	        });
	    });
	</script>
</body>
</html>