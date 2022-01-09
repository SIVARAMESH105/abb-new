    @include("Site.header")
    <div class="secondary-top">
        <div class="container container-md search-content">
            <div class="bg-white-section">
                <div class="row">
                    <div class="col-xs-12">
                        <div><h2>Users</h2></div>
                        {!! csrf_field() !!}
                        <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
						<div class="table-responsive">
                            <table id="users-table" class="table table-bordered display" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Home Phone</th>
                                        <th>Register Date</th>
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
				"url": base_url+"/affiliate/referenceUsers",
				headers: {'X-CSRF-TOKEN': token},
				"type": "POST"
			},
			columns: [
				{ data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'home_phone', name: 'home_phone' },
                { data: 'created_at', name: 'created_at'}
			]
		});
	});
</script>