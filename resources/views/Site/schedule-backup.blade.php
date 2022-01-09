            @include("Site.header")
        <div class="secondary-top">
            <div class="container container-md">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					 <?php echo $pageContent[0]->content; ?>
                    <section class="advantage">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="title">
                                    <h2>Advantage Basketball Camps Schedule 2017</h2>
                                </div>
                                <div class="each-advantage">
                                    <h6>Youth Sports Camps With A Positive Difference</h6>
                                    <p>This is a list of 2017 camps currently scheduled. <a class="camps-link" href="#camps">Please scroll down to view the current list.</a> We may be adding new location/camps and will post them here as soon as they are confirmed. Please do not call and ask if a camp is coming to your area if you do not see it below. Feel free to send an e-mail and ask about camps in your area if you wish.</p>
									<p>If you would like to host a camp in your area as a fund raiser for your school, then please e-mail your request to us and we will be happy to bring our world-renowned program to your school.</p>
									<p>
										<ul class="content-links">
											<li><a href="{{ url('staff') }}">Meet one of the top coaching staffs in the world</a></li>
											<li><a href="{{ url('shootingcamp') }}">Learn some great tips now from our Shooting Camps</a></li>
										</ul>
									</p>
									<p>We have three types of camps: Shooting, Ball-Handling, and "Specialty Camps". The Specialty Camps are an advanced camp covering a wide range of topics from defense to offense, court awareness, shooting and more. Specialty camps will only happen over Winter and Spring Break each year.
									</p>
									<p>
									<ul class="content-links">
										<li><a href="#">Learn more about the camps</a></li>
										<li><a href="#">For more information about a typical daily agenda</a></li>
										<li><a href="#">Discover the successful coaching methods used at our camps</a></li>
										<li><a href="#">View an informative video of our camps</a></li>
									</ul>
									</p>
                                </div>
								<div class="title" id="camps">
                                    <h2>Find a Camp</h2>
                                </div>
                                <div class="each-advantage" >
                                   <p>More camps coming soon! If you don't see a camp in your area, check back soon or <a href="{{ url('contact') }}">contact us</a> for more information. Or, enter your e-mail address in the left column (below the "View Camps" button) and we'll notify you about new camps.
									</p>
                                </div>
                                <form action="" class="form-horizontal">
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="selectbasic">Select a country</label>
									  <div class="col-md-3 col-sm-6 col-xs-12">
										<select id="country_val" name="country" class="form-control input-md">
											<?php $c_id = Request::segment(1);
											if($c_id =='schedule'){
												$c_id = 1;
											}else if(Request::segment(2) == 'registerState' || Request::segment(2) == 'sortMonth'){
												$c_id = Request::segment(4);
											}
											else{
												$c_id = Request::segment(3);
											}?>
											@foreach($country_details as $details)
												<option value="{{$details->country_id}}" {{($details->country_id == $c_id) ? 'selected="selected"' : ''}} >{{$details->country_name}}</option>
											@endforeach
										</select>
									  </div>
									</div>
									<div class="form-group">
							  		  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Select a state/province:</label>
									  <div class="col-md-3 col-sm-6 col-xs-12">
		  									 @foreach($state_details as $details)
											<a href="{{ url('camp/registerState/'.$details->state_id.'/'.$details->country_id) }}" @if(Request::segment(3)== $details->state_id) class="state-active" @endif >{{$details->state_code}}</a>
											@endforeach  
									  	  <!-- <div class="btn-group  schedule-btn-group">
									  		<button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select<span class="caret"></span></button>
									  		<ul class="dropdown-menu">
												@foreach($state_details as $details)
												<li><a href="{{ url('camp/registerState/'.$details->state_id.'/'.$details->country_id) }}">{{$details->state_code}}</a></li>
												@endforeach
									  		</ul>
									  	</div> --> 
									  </div>
							        </div>	
							        <div class="form-group">
									  	<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Select a season:</label>
										 <div class="col-md-3 col-sm-6 col-xs-12">
											<a href="{{ url('camp/sortMonth/0/'.$c_id) }}" @if(Request::segment(3)== 0) class="season-active" @endif >All</a>
											<a href="{{ url('camp/sortMonth/1/'.$c_id) }}" @if(Request::segment(3)== 1) class="season-active" @endif >Jan</a>
											<a href="{{ url('camp/sortMonth/2/'.$c_id) }}" @if(Request::segment(3)== 2) class="season-active" @endif >Feb</a>
											<a href="{{ url('camp/sortMonth/3/'.$c_id) }}" @if(Request::segment(3)== 3) class="season-active" @endif >Mar</a>
											<a href="{{ url('camp/sortMonth/4/'.$c_id) }}" @if(Request::segment(3)== 4) class="season-active" @endif >Apr</a>
											<a href="{{ url('camp/sortMonth/5/'.$c_id) }}" @if(Request::segment(3)== 5) class="season-active" @endif >May</a>
											<a href="{{ url('camp/sortMonth/6/'.$c_id) }}" @if(Request::segment(3)== 6) class="season-active" @endif >Jun</a>
											<a href="{{ url('camp/sortMonth/7/'.$c_id) }}" @if(Request::segment(3)== 7) class="season-active" @endif >Jul</a>
											<a href="{{ url('camp/sortMonth/8/'.$c_id) }}" @if(Request::segment(3)== 8) class="season-active" @endif >Aug</a>
											<a href="{{ url('camp/sortMonth/9/'.$c_id) }}" @if(Request::segment(3)== 9) class="season-active" @endif >Sep</a>
											<a href="{{ url('camp/sortMonth/10/'.$c_id) }}" @if(Request::segment(3)== 10) class="season-active" @endif>Oct</a>
											<a href="{{ url('camp/sortMonth/11/'.$c_id) }}" @if(Request::segment(3)== 11) class="season-active" @endif>Nov</a>
											<a href="{{ url('camp/sortMonth/12/'.$c_id) }}" @if(Request::segment(3)== 12) class="season-active" @endif>Dec</a>
										</div> 
										<!-- <div class="col-md-3 col-sm-6 col-xs-12">
											<div class="btn-group schedule-btn-group">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select<span class="caret"></span></button>
												<ul class="dropdown-menu">
													<li><a href="{{ url('camp/sortMonth/0/'.$c_id) }}">All</a></li>
													<li><a href="{{ url('camp/sortMonth/1/'.$c_id) }}">Jan</a></li>
													<li><a href="{{ url('camp/sortMonth/2/'.$c_id) }}">Feb</a></li>
													<li><a href="{{ url('camp/sortMonth/3/'.$c_id) }}">Mar</a></li>
													<li><a href="{{ url('camp/sortMonth/4/'.$c_id) }}">Apr</a></li>
													<li><a href="{{ url('camp/sortMonth/5/'.$c_id) }}">May</a></li>
													<li><a href="{{ url('camp/sortMonth/6/'.$c_id) }}">Jun</a></li>
													<li><a href="{{ url('camp/sortMonth/7/'.$c_id) }}">Jul</a></li>
													<li><a href="{{ url('camp/sortMonth/8/'.$c_id) }}">Aug</a></li>
													<li><a href="{{ url('camp/sortMonth/9/'.$c_id) }}">Sep</a></li>
													<li><a href="{{ url('camp/sortMonth/10/'.$c_id) }}">Oct</a></li>
													<li><a href="{{ url('camp/sortMonth/11/'.$c_id) }}">Nov</a></li>
													<li><a href="{{ url('camp/sortMonth/12/'.$c_id) }}">Dec</a></li>
									  			</ul>
											</div>	
										</div> -->
									</div>
									<div class="form-group camp-group">
					  					<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Camps:</label>
											@if($camp_details->isEmpty())
												<div class="col-md-4">
													<h4>No camps found</h4>
												</div>
											@else
										<div class="col-md-3 col-sm-6 col-xs-12">
											<?php $array_val = array();?>
												@foreach($camp_details as $details)
												
												@if(in_array($details->state_name, $array_val))
													<h4></h4>
												@else
													<?php array_push($array_val, $details->state_name);?>
													<h4>{{$details->state_name}}</h4>
												@endif
												<?php $array_val = array_unique($array_val); ?>
												
												<p><b>{{$details->City}}, {{$details->state_name}}</b></p>
												<p>{{$details->camp_focus}}</p>     
												<p>{{$details->Location}} <a>(map)</a> </p>
												<p>{{$details->Address}}, {{$details->City}} {{$details->Zip}}</p>   
												{{$details->startdate}} - {{$details->enddate	}}, {{$details->starttime}} to {{$details->endtime}}
												Cost: $ {{$details->cost}}  @if($details->EarlyBirdDiscount != 0)Save ${{$details->EarlyBirdDiscount}} if you register before July 13! @endif
												Contact: {{$details->contact}}
												<a href="{{ url('camp/register/'.$details->id) }}">Register now</a> </p>
												@endforeach
										</div>
										@endif
									</div>
                                </form>
							</div>
							
						</div>
							
					</section>
					
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	@php $base_url = \URL::to(''); @endphp
	<script>
	$('#country_val').change(function() { 
		var cid = $('#country_val').val();
		var b_url = '{{url("/")}}';
		window.location.href = b_url+"/camp/countrySort/"+cid;
	});
	</script>
</body>
</html>
