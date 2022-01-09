<label class="control-label" for="coachers">Coach</label>
<select name="coachers[]" id="coachers" class="form-control input-md" multiple>	       
	<option disabled>-- Select Coach --</option>
	@if($count >0)	                      	
		@foreach($coachName as $coach)
			<option value="{{ $coach->id }}">{{ $coach->first_name.' '.$coach->last_name }}</option>
		@endforeach
	@else
		<option disabled>No records found!</option>
	@endif
</select>