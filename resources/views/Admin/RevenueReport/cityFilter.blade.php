<label class="control-label" for="cities">City</label>
	<select name="cities[]" id="cities" class="form-control input-md" multiple >	       
	    	<option disabled>-- Select City --</option>
			@if($count >0)
				@if(Auth::user()->user_type == 1)
					<option value ="all">All Cities</option> 
				@endif
				@foreach($cityName as $val)
					<option value="{{ $val->Id }}">{{ $val->City }}</option>
				@endforeach
			@else
				<option disabled>No records found!</option>
			@endif
	</select>
	
<hr>
<hr/>
<div class="location-div">
<label class="control-label" for="locations">Location</label>

	<select name="locations[]" id="locations" class="form-control input-md" multiple>	       
		<option disabled>-- Select Location --</option>
		@if($count >0)
			@if(Auth::user()->user_type == 1)  
				<option value ="all">All Locations</option> 
			@endif
			@foreach($cityName as $val)
				<option value="{{ $val->Id }}">{!! $val->Location !!}</option>
			@endforeach
		@else
			<option disabled>No records found!</option>
		@endif
	</select>
	
</div>