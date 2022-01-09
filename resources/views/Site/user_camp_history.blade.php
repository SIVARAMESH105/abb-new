    @include("Site.header")
    <div class="secondary-top">
        <div class="container container-md search-content">
            @if (session('status'))          
                <div class="alert alert-success">  
                    <a class="panel-close close" data-dismiss="alert">&times;</a>                
                    {{ session('status') }}
                </div>
            @endif

             @if (session('status-error'))          
                <div class="alert alert-danger">  
                    <a class="panel-close close" data-dismiss="alert">&times;</a>                
                    {{ session('status-error') }}
                </div>
            @endif
			
			 @if($errors->any())
              <div class="alert alert-danger">
                <a class="panel-close close" data-dismiss="alert">&times;</a>
                {{$errors->first()}}
              </div>
            @endif
            
            <div id="errorresponse" style="display:none;" class="alert alert-danger">
            </div>
            <div id="successresponse" style="display:none;" class="alert alert-success">
            </div>
            
            <div class="modal fade " id="non-group" tabindex="-1" role="dialog" aria-labelledby="non-group">
                <div class="modal-dialog" role="document" style="width:850px; margin:0 auto;">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="modal-body"> 
                            <div class="item">
                                <div class="popup-view">
                                    <div class="popup-block">
                                        <form method="post" class="form-horizontal" id="refund-enroll" action="{{url('user/refundEnroll')}}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="camp-id" id="camp-id" value=""/>
                                            <input type="hidden" name="roster-id" id="roster-id" value=""/>
                                            <input type="hidden" name="camp-amt" id="camp-amt" value=""/>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>If you cancel a camp registration, you can receive a refund less $95, or you can apply the entire amount toward a future camp.</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="radio-inline" for="refund-0">
                                                        <input type="radio" name="refund" id="refund-0" value="refund" checked="checked"> I want to receive a refund, less a handling fee of $95.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="radio-inline" for="refund-1">
                                                        <input type="radio" name="refund" id="refund-1" value="enrollment"> I prefer to receive the full amount of my payment as a credit toward a future camp enrollment.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-4 col-md-offset-1 col-sm-7 col-xs-12 control-label">&nbsp;</label>
                                                <div class="col-md-12">
                                                     <button type="submit" id="refund-submit" name="refund-submit" value="submit" class="btn btn-primary">SUBMIT</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="bg-white-section">
                <div class="row">
                    <div class="col-xs-12">
                        <div><h2>Registered Camps</h2></div>
                        {!! csrf_field() !!}
                        <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
						<div class="table-responsive">
                            <table id="users-table" class="table table-bordered display" >
                                <thead>
                                    <tr>
                                        <th>Camp Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Registered Date</th>
                                        <th>Cost</th>
                                        <th>Address</th>
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
            "url": base_url+"/user/getlist",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'camp_focus', name: 'camp_focus' },
            { data: 'startdate', name: 'startdate' },
            { data: 'enddate', name: 'enddate' },
            { data: 'starttime', name: 'starttime' },
            { data: 'endtime', name: 'endtime' },
            { data: 'last_update', name: 'last_update' },
            { data: 'cost', name: 'cost' },
            { data: 'Address', name: 'Address' },
            { data: 'Location', name: 'Location' },
            { data: 'City', name: 'City' },
            { data: 'country_name', name: 'country_name' },
            { data: 'action', name: 'action' }
        ]
	});

    $(document).on('click', '#cancelcamp', function() {
        var timezone_offset_minutes = new Date().getTimezoneOffset();
        timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;

        // Timezone difference in minutes such as 330 or -360 or 0
        
        var campid = $(this).attr('data-attr');
        var roster_id = $(this).attr('data-rosterId');
        var is_discount = $(this).attr('data-discount');
        var camp_amt = $(this).attr('data-amt');
        if(is_discount=='yes') {
            $("#errorresponse").text("We\'re sorry, camp registrations which were made using a group discount cannot be canceled. You can only receive a credit toward a future camp registration.").show();
            closeAlertNotification();
        } else {
            //To verify the date
            $.ajax({
                "url": base_url+"/user/checkdate",
                headers: {'X-CSRF-TOKEN': token},
                "type": "POST",
                "data":{"_token":token, "campid":campid, 'timezone_offset_minutes':timezone_offset_minutes},
                "success":function(data) {
                   if(data < 24) {
                        $("#errorresponse").text("We\'re sorry, camp registrations cannot be canceled less than 24 hours before the start of camp.").show();
                        closeAlertNotification();
                   } else if(data == 'past') {
                        $("#errorresponse").text("We\'re sorry, camp registrations cannot be canceled because the camp already started.").show();
                        closeAlertNotification();
                   } else {
                        //window.location.href = base_url+"/user/cancelCamp/"+roster_id;
                        $('#camp-id').val(campid);
                        $('#roster-id').val(roster_id);
                        $('#camp-amt').val(camp_amt);
                        $('#non-group').modal('show');
                    }
                }
            });  
        }
       
    });

    function closeAlertNotification() {
        setTimeout(function(){
            jQuery('#errorresponse').fadeOut();
            jQuery('#successresponse').fadeOut();
        }, 4000);
    }

    $('form#refund-enroll').submit(function(event) {
        var refund = $('input[name="refund"]:checked').val();
        if(refund=="refund") {
            return true;
        } else {
            var campAmt = $('#camp-amt').val();
            if (confirm("Your account has been credited for the amount of your registration, $"+campAmt+".  To use this credit, simply register for another camp and apply the credit upon checkout.")) {
                return true;
            }
        }
        return false;
    });
});
</script>