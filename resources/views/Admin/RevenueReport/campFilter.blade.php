<label class="control-label" for="camps">Camps</label>
<select name="camps[]" id="camps" class="form-control input-md" multiple>	       
	<option disabled>-- Select Camp --</option>
	@if($count >0)
		@if(Auth::user()->user_type == 1)
		<option value ="all">All Camps</option> 
		@endif            
		@foreach($campName as $camp)
			<option data-toggle="tooltip" data-container="#tooltip_container" title="{{ $camp->camp_focus }}, {!!strip_tags($camp->Location) !!}, {!! $camp->City!!}, {{$camp->state_code}}, {{$camp->startdate}} to {{$camp->enddate}}" value="{{ $camp->id }}">{{ $camp->camp_focus }}</option>
		@endforeach
	@else
		<option disabled>No records found!</option>
	@endif
</select>





