@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
    		<span class="text-capitalize">Reports</span>
	  	</h1>
	  	<ol class="breadcrumb">
	    	<li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    	<li class="active">Reports</li>
	  	</ol>
	</section>
@endsection

@section('content')
	<div class="row">
		@if(backpack_user()->user_type != 2)
			<div class="col-sm-12 col-md-6">
				<div class="box box-solid">
					<a class="popup-models reportstitle btn btn-primary ladda-button" id="modal-one" data-target="#rostersModal" data-toggle="modal" onclick="openRostersModal();">
						<div class="box-body">
							<div class="media">
								Rosters
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="box box-solid">
					<a class="popup-models reportstitle btn btn-primary ladda-button" id="modal-one" data-target="#revenueModal" data-toggle="modal" onclick="openRevenueModal();">
						<div class="box-body">
							<div class="media">
								Revenue
							</div>
						</div>
					</a>
				</div>
			</div>
		@endif
		
     	{{-- Visible Only for admins --}}
     	@if(backpack_user()->user_type == 1)
	     	<div class="col-sm-12 col-md-6">
		        <div class="box box-solid">
		        	<a class="reportstitle btn btn-primary ladda-button" href = "{{ url('admin/directorReport') }}" >
			            <div class="box-body">
			                <div class="media">
			                    Director List
			                </div>
			            </div>
		            </a>
		        </div>
	     	</div>
     	@endif
		@if(backpack_user()->user_type != 2)
     	<div class="col-sm-12 col-md-6">
	        <div class="box box-solid">
	        	<a class="popup-models reportstitle btn btn-primary ladda-button" id="modal-one" data-target="#coachAssignmentsModal" data-toggle="modal" onclick="openCoachAssignmentsModal();">
		            <div class="box-body">
		                <div class="media">
		                    Coach Assignments
		                </div>
		            </div>
	            </a>
	        </div>
     	</div>
		@endif
	</div>

	<!-- Model box -->
    <div class="modal fade " id="rostersModal" tabindex="-1" role="dialog" aria-labelledby="rostersModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="rostersModal">                       
	                    <div class="item revenueSlides">
	                        <div class="popup-view">
	                            <div class="popup-block">
	                                <h4>Roster Report</h4>
	                                <form method="post" class="form-horizontal" id="rosterForm" action="{{url('admin/rosterReports')}}">
	                                	{{ csrf_field() }}
	                                	<label  class="control-label" for="states">State</label>
		                                <select name="states[]" id="states" class="form-control input-md" multiple>	   	
		                                	<option disabled>-- CTRL+Click to select --</option>                             	
		                            		@foreach($stateList as $states)
		                            			<option value="{{ $states->state_id }}">{{ $states->state_name }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="cities">City</label>
		                                <select name="cities[]" id="cities" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($cityList as $city)
		                            			<option value="{{ $city->Id }}">{{ $city->City }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="locations">Location</label>
		                                <select name="locations[]" id="locations" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($locationList as $location)
		                            			<option value="{{ $location->Id }}">{{ $location->Location }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="coachers">Coach</label>
		                                <select name="coachers[]" id="coachers" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($coachList as $coach)
		                            			<option value="{{ $coach->id }}">{{ $coach->first_name.' '.$coach->last_name }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <div>
		                                	<input type="submit" name="rostersubmit" class="btn btn-success" value="Submit"/>
		                                </div>		                                
	                            	</form>
	                            </div>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="revenueModal" tabindex="-1" role="dialog" aria-labelledby="revenueModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="revenueModal">                       
	                    <div class="item revenueSlides">
	                        <div class="popup-view">
	                            <div class="popup-block">
	                                <h4>Revenue report</h4>
	                                <form method="post" class="form-horizontal" id="revenueForm" action="{{url('admin/revenueReports')}}">
	                                	{{ csrf_field() }}
	                                	<div class="form-group">
										    <label class="col-md-2 control-label" for="startdate">Begin Date</label>  
										    <div class="col-md-4  error-cls">
										        <input name="startdate" type="text" id="startdate" class="form-control input-md" autocomplete="off">
										    </div>
										    <label class="col-md-2 control-label" for="enddate">End Date</label>  
										    <div class="col-md-4  error-cls">
										        <input name="enddate" type="text" id="enddate" class="form-control input-md" autocomplete="off"> 
										    </div>
										</div>
										{{-- Visible Only for admins --}}
     									@if(backpack_user()->user_type == 1)
			                                <label class="control-label" for="directors">Director</label>
			                                <select name="directors[]" id="directors" class="form-control input-md" multiple>	       
			     								<option disabled>-- Select Director --</option>
			                                	<option value ="all">All Directors</option>
			                            		@foreach($directorList as $director)
			                            			<option value="{{  $director->name }}">{{ $director->name }}</option>
			                            		@endforeach
			                                </select>
			                                <hr/>
		                                {{-- Assign single director if director login --}}
										@elseif(backpack_user()->user_type == 4)			     
											<input type="hidden" name="directors[]" value="{{ backpack_user()->name }}">
		                                @endif
										<div class="coach-div">
		                                	<label class="control-label" for="coachers">Coach</label>
			                                <select name="coachers[]" id="coachers" class="form-control input-md" multiple>	       
			                                	<option disabled>-- Select Coach --</option>    	
			                            		@foreach($coachList as $coach)
			                            			<option value="{{ $coach->id }}">{{ $coach->first_name.' '.$coach->last_name }}</option>
			                            		@endforeach
			                                </select>
		                                </div>
		                                <hr/>
										<label  class="control-label" for="states">State</label>
		                                <select name="states[]" id="states" class="form-control input-md" multiple>	   	
		                                	<option disabled>-- Select State --</option>
		                                	@if(backpack_user()->user_type == 1)
		                                	<option value ="all">All States</option> 
		                                	@endif             
		                                	@foreach($stateList as $states)
		                            			<option value="{{ $states->state_id }}" >{{ $states->state_name }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <div class="city-div">
		                                	<label class="control-label" for="cities">City</label>
			                                <select name="cities[]" id="cities" class="form-control input-md" multiple >	       
			                                	<option disabled>-- Select City --</option>
			                                	@if(backpack_user()->user_type == 1)
			                                	<option value ="all">All Cities</option> 
			                                	@endif  
			                            		@foreach($cityList as $city)
			                            			<option value="{{ $city->Id }}">{{ $city->City }}</option>
			                            		@endforeach
			                                </select>
		                                	<hr/>
			                                <div class="location-div">
				                                <label class="control-label" for="locations">Location</label>
				                                <select name="locations[]" id="locations" class="form-control input-md" multiple>	       
				                                	<option disabled>-- Select Location --</option>  
				                                	@if(backpack_user()->user_type == 1)
				                                	<option value ="all">All Locations</option>
				                                	@endif   
				                            		@foreach($locationList as $location)
				                            			<option value="{{ $location->Id }}">{!! $location->Location !!}</option>
				                            		@endforeach
				                                </select>
			                                </div>
			                            </div>
		                                <hr/>
		                                <div class="camp-div">
			                                <label class="control-label" for="camps">Camps</label>
			                                <select name="camps[]" id="camps" class="form-control input-md" multiple>	       
			                                	<option disabled>-- Select Camp --</option>
			                                	@if(backpack_user()->user_type == 1)
			                                	<option value ="all">All Camps</option> 
			                                	@endif              
			                                	@foreach($campList as $camp)
			                            			<option data-toggle="tooltip" data-container="#tooltip_container" title="{!! $camp->camp_focus !!}, {!!strip_tags($camp->Location) !!}, {!! $camp->City!!}, {{$camp->state_code}}, {{$camp->startdate}} to {{$camp->enddate}}" value="{{ $camp->id }}">{{ $camp->camp_focus }}</option>
			                            		@endforeach
			                                </select>
		                                </div>
										 <hr/>
										<div class="form-group">
											<label class="col-md-2 col-sm-4 col-xs-12 control-label" for="display">Display</label> 
											<div class="col-md-8 col-sm-10 col-xs-12  error-cls">
												<div class="radio">
													<label for="options_display1">
														<input type="radio" name="options_display" id="options_display1" value="1"  required>
														All camper details,camp totals,grand totals
													</label>
												</div>
												<div class="radio">
													<label for="options_display2">
														<input type="radio" name="options_display" id="options_display2" value="2">
														Camp totals,grand totals
													</label>
												</div>
												<div class="radio">
													<label for="options_display3">
														<input type="radio" name="options_display" id="options_display3" value="3">
														Grand totals only
													</label>
												</div>
											</div>
										</div>	
		                                <div>
		                                	<input type="submit" name="revenuesubmit" class="btn btn-success" value="Submit"/>
		                                </div>		                                
	                            	</form>
	                            </div>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade " id="coachAssignmentsModal" tabindex="-1" role="dialog" aria-labelledby="coachAssignmentsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="coachAssignmentsModal">                       
	                    <div class="item coachAssignmentsSlides">
	                        <div class="popup-view">
	                            <div class="popup-block">
	                                <h4>Coach Assignments Report</h4>
	                                <form method="post" class="form-horizontal" id="coachAssignmentsForm" action="{{url('admin/coachAssignmentsReports')}}">
	                                	{{ csrf_field() }}
	                                	<label  class="control-label" for="states">State</label>
		                                <select name="states[]" id="states" class="form-control input-md" multiple>	   	
		                                	<option disabled>-- CTRL+Click to select --</option>                             	
		                            		@foreach($stateList as $states)
		                            			<option value="{{ $states->state_id }}">{{ $states->state_name }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="cities">City</label>
		                                <select name="cities[]" id="cities" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($cityList as $city)
		                            			<option value="{{ $city->Id }}">{{ $city->City }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="locations">Location</label>
		                                <select name="locations[]" id="locations" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($locationList as $location)
		                            			<option value="{{ $location->Id }}">{{ $location->Location }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                <label class="control-label" for="camps">Camps</label>
		                                <select name="camps[]" id="camps" class="form-control input-md" multiple>	       
		                                	<option disabled>-- CTRL+Click to select --</option>                         	
		                            		@foreach($campList as $camp)
		                            			<option value="{{ $camp->id }}">{{ $camp->camp_focus }}</option>
		                            		@endforeach
		                                </select>
		                                <hr/>
		                                {{-- Visible Only for admins --}}
     									@if(backpack_user()->user_type == 1)
			                                <label class="control-label" for="directors">Director</label>
			                                <select name="directors[]" id="directors" class="form-control input-md" multiple>	       
			                                	<option disabled>-- CTRL+Click to select --</option>
			                            		@foreach($directorList as $director)
			                            			<option value="{{ $director->name }}">{{ $director->name }}</option>
			                            		@endforeach
			                                </select>
			                                <hr/>
		                                {{-- Assign single director if director login --}}
										@elseif(backpack_user()->user_type == 4)			     
											<input type="hidden" name="directors[]" value="{{ backpack_user()->name }}">                            
		                                @endif
		                                <div>
		                                	<input type="submit" name="coachAssignmentssubmit" class="btn btn-success" value="Submit"/>
		                                </div>		                                
	                            	</form>
	                            </div>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!--Coach revenue modal window-->
	<div class="modal fade " id="coachRevenueModal" tabindex="-1" role="dialog" aria-labelledby="revenueModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="revenueModal">                       
	                    <div class="item revenueSlides">
	                        <div class="popup-view">
	                            <div class="popup-block">
	                                <h4>Revenue report</h4>
	                                <form method="post" class="form-horizontal" id="revenueForm" action="{{url('admin/coachRevenueReport')}}">
	                                	{{ csrf_field() }}
	                                	<div class="form-group">
										    <label class="col-md-2 col-sm-4 col-xs-12 control-label" for="startdate">Begin Date</label>  
										    <div class="col-md-8 col-sm-10 col-xs-12  error-cls">
										        <input name="cstartdate" required type="text" id="cstartdate" class="form-control input-md" autocomplete="off">
										    </div>
										</div>
										<div class="form-group">
										    <label class="col-md-2 col-sm-4 col-xs-12 control-label" for="enddate">End Date</label>  
										    <div class="col-md-8 col-sm-10 col-xs-12  error-cls">
										        <input name="cenddate" required type="text" id="cenddate" class="form-control input-md" autocomplete="off"> 
										    </div>
										</div>
		                                <div>
		                                	<input type="submit" name="coachrevenuesubmit" class="btn btn-success" value="Submit"/>
		                                </div>		                                
	                            	</form>
	                            </div>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Coach revenue modal window-->
@endsection

@section('after_scripts')
	<script type="text/javascript">
		jQuery(document).ready(function(){
			document.getElementById("rosterForm").reset();
			jQuery('#startdate,#cstartdate').datepicker({
    			autoclose: true,
		        clearBtn: true
    		});
    		jQuery('#enddate,#cenddate').datepicker({
    			autoclose: true,
		        clearBtn: true
    		});
		});
		function openRostersModal() {
          	document.getElementById('rostersModal').style.display = "block";
        }
        function openRevenueModal() {
          	document.getElementById('revenueModal').style.display = "block";
			//For Default Arizona value set using Jquery
			 $("#revenueForm>#states option[value='3']").attr("selected", "selected");
			 var defaultToken = jQuery('meta[name="csrf-token"]').attr('content');
			 var requestURL = "<?php echo url('admin/ajaxGetStateReportCityName'); ?>";
			 var state_id = [$( "#revenueForm>#states option:selected" ).val()];
			 $.ajax({
				url: requestURL,
				type: 'POST',
	            data: { "_token":defaultToken, stateId: state_id},
	            success: function(data) {
	                jQuery(".city-div").html(data);
	            } 
			 });

        }
        function openCoachAssignmentsModal() {
          	document.getElementById('coachAssignmentsModal').style.display = "block";
        }
		function openCoachRevenueModal() {
			document.getElementById('coachRevenueModal').style.display = "block";
		}
		jQuery(document).on('change','#states',function(){
	        var state_id = jQuery(this).val();
	        var token = jQuery('meta[name="csrf-token"]').attr('content');
			url = "<?php echo url('admin/ajaxGetStateReportCityName'); ?>";
	        jQuery.ajax({
	            url: url,
				type: 'POST',
	            data: { "_token":token, stateId: state_id},
	            success: function(data) {
	                jQuery(".city-div").html(data);
	            }
	        });
    	});
    	jQuery(document).on('change','#cities',function(){
	        var city_id = jQuery(this).val();
			var token = jQuery('meta[name="csrf-token"]').attr('content');
	        url = "<?php echo url('admin/ajaxGetCityReportLocationName'); ?>";
	        jQuery.ajax({
				url: url,
	            type: 'POST',
				data: {"_token":token, city_id: city_id},
	            success: function(data) {
	                jQuery(".location-div").html(data);
	            }
	        });
    	});
    	jQuery(document).on('change','#locations',function(){
	        var location_id = jQuery(this).val();
			var token = jQuery('meta[name="csrf-token"]').attr('content');
	        url = "<?php echo url('admin/ajaxGetLocationReportCampName'); ?>";
	        jQuery.ajax({
				url: url,
	            type: 'POST',
	            data: {"_token":token, location_id: location_id},
	            success: function(data) {
	                jQuery(".camp-div").html(data);
	            }
	        });
    	});

    	jQuery(document).on('change','#directors',function(){
	        var director_name = jQuery(this).val();
			var token = jQuery('meta[name="csrf-token"]').attr('content');
	        url = "<?php echo url('admin/ajaxGetDirectorReportCoachName'); ?>";
	        jQuery.ajax({
				url: url,
	            type: 'POST',
				data: {"_token":token, director_name: director_name},
	            success: function(data) {
	                jQuery(".coach-div").html(data);
	            }
	        });
    	});

	</script>
	<script src="{{ asset('public/vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('public/vendor/adminlte/plugins/datepicker/datepicker3.css') }}">
@endsection