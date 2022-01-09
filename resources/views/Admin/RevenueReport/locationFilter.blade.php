<label class="control-label" for="locations">Location</label>
<select name="locations[]" id="locations" class="form-control input-md" multiple>	       
	<option disabled>-- Select Location --</option> 
	@if($count >0)	
		@if(Auth::user()->user_type == 1) 
			<option value ="all">All Locations</option>
		@endif 
		@foreach($locationName as $location)
			<option value="{{ $location->Id }}">{!! $location->Location !!}</option>
		@endforeach
	@else
		<option disabled>No records found!</option>
	@endif
</select>