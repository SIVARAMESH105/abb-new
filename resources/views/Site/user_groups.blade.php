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
                    <div class="other-info">
                        <div class="table-title">
                          <label><h2>User Groups</h2></label>
                          {!! csrf_field() !!}
                          <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
                        </div>
                        <div class="table-button">
                          <a href="{{ url('user/addGroup') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 10px;">Add Group</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="users-table">
                            <thead>
                                <tr>
                                    <th>Camp Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Group Code</th>
                                    <th>Invities Count</th>
                                    <th>Location</th>
                                    <th>City</th>
                                    <th>Country</th>
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
            "url": base_url+"/user/getGroupslist",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'camp_focus', name: 'camp_focus' },
            { data: 'startdate', name: 'startdate' },
            { data: 'enddate', name: 'enddate' },
            { data: 'group_code', name: 'group_code',orderable: false, searchable: true},
            { data: 'counts', name: 'counts' },
			{ data: 'Location', name: 'Location' },
            { data: 'City', name: 'City' },
            { data: 'country_name', name: 'country_name' },
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

