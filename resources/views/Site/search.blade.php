    @include("Site.header")
        <div class="secondary-top">
            <div class="container container-md ">
                <div class="bg-white-section">
                    <h2 class="text-center">Search Result for {{ucwords($searchData)}} </h2>
                    <section class="with-sidebar-layout">
                        <div class="content-body-wrap search-data">
                           
                        @if(count($campsAndCMS)>0 && (count($campsAndCMS['camsRes'])>0 || count($campsAndCMS['cmsContent'])>0))
                            
                            @if(count($campsAndCMS['camsRes']) >0)
                                <h1>Camps</h1>
                                @foreach ($campsAndCMS['camsRes'] as $camp)
                                    <div class="search-results">
                                        <h2>{!! $camp->state_name !!}</h2>
                                        <p><b>{!! $camp->City !!},{!!$camp->state_name!!}</b></p>
                                        <p>{!! $camp->camp_focus !!}</p>
                                        <p>{!! $camp->startdate !!} - {!! $camp->enddate !!}</p>
                                        <span class="more">View more details...</span>
                                        <div class="complete"><p>{!! $camp->starttime !!} to {!! $camp->endtime!!}</p><p>{!! $camp->Address !!}, {!!$camp->City!!}{!! $camp->Zip!!}</p>
                                        <p>{!! $camp->Location!!}<a class="campmap" href="https://www.google.com/maps?q={{ $camp->Address }},{{ $camp->City }} {{ $camp->Zip }},{{ $camp->Location}}&output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a> </p><p><b>Cost:</b> ${{ $camp->cost}}</p><p><b>Contact:</b>{{ $camp->contact}}</p><p><a href="{{URL::to('/')}}/camp/register/{!! $camp->id!!}">Register now</a></p></p></div>
                                    </div>
                                @endforeach
                            @endif
                            @if(count($campsAndCMS['locationRes'])>0)
                            <h1>Location</h1>
                            @foreach($campsAndCMS['locationRes'] as $val)
                                <div class="search-results">
                                    <h2>{!!$val->camp_focus!!}</h2>
                                    <p><b>{!!$val->Location!!}</b></p>
                                    <p>{!!$val->Address!!}</p>
                                    <p>@if(!empty($val->City)){!!$val->City !!},@endif {!!$val->state_name!!} {!!$val->Zip!!}</p>
                                    <p>@if(!empty($val->startCamp))<b>Dates:</b>{!!$val->startCamp!!} - {!!$val->endCamp!!}@endif</p>
                                    <div class="complete" style="display: inline;">
                                    <p>@if(!empty($val->campstarttime))<b>Hours:</b>{!!$val->campstarttime!!} to {!!$val->campendtime!!}@endif</p>
                                    <p>@if(!empty($val->cost))<b>Cost:</b>$ {!!$val->cost!!}@endif</p>
                                    <p>@if(!empty($val->EarlyBirdDiscount))<b>Early-bird discount:</b>{!!$val->EarlyBirdDiscount!!}@endif<p>@if(!empty($val->contact))<b>Contact:</b>{!!$val->contact!!}@endif</p>
                                    <a class="campmap text-underline" href="https://www.google.com/maps?q=@if(!empty($val->Address)){!!$val->Address!!},@endif{!!$val->City !!} @if(!empty($val->Zip)){!!$val->Zip!!},@endif{!!$val->Location!!}&amp;output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a></p>
                                    <p><a class="text-underline" href="{{URL::to('/')}}/camp/register/{!!$val->id!!}">Register now</a></p></div>
                                </div>
                            @endforeach
                            @endif
                            @if(count($campsAndCMS['cmsContent'])>0)
                            <h1>Pages</h1>
                                @foreach ($campsAndCMS['cmsContent'] as $val)
                                    <div class="search-results mb-10">
                                        <h3><a class="text-underline"  href="{{url($val->title)}}" target="_blank">{!!$val->title!!}</a></h3>
                                        <!--Strips tags for remove the html tag.-->
                                        <!--Strlength for minimize the content.-->
                                        <p><a   href="{{url($val->title)}}" target="_blank"> {!!str_limit((strip_tags($val->content)),85)!!}</a></p>  
                                    </div>
                                @endforeach
                            @endif
                        @else
                        <section class="search-results">
							<section class="search-data no-search">
								<h3>No search content found!</h3>
							</section>
						</section>
                        @endif
                        </div>
                        <div class="side-bar-wrap">
                        <form name="ccoptin" class="form-horizontal" action="https://visitor.constantcontact.com/d.jsp" target="_blank" method="post">                    
                            <input type="hidden" name="m" value="1101857529536">
                            <input type="hidden" name="p" value="oi">
                            <div class="form-group">
                              <label class="control-label" for="add2">GET NOTIFIED ABOUT LOCAL CAMPS. ENTER YOUR E-MAIL TO SUBSCRIBE:</label>  
                              <div class="error-cls">
                              <input type="text" name="ea" size="14" value="" class="form-control input-md">
                              </div>
                            </div>

                            <div class="form-group sidebar-form-button">
                              <label class="control-label" for="submit">THEN CLICK</label>
                              <div class="">
                                <input type="submit" name="go" value="Go" class="submit btn" />
                              </div>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>


<!-- For Map Popup-->
<div id="modalRegister" class="modal fade" role="dialog">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img aria-hidden="true" src="{{ asset('public/images/close.png') }}" alt="Close" title="Close"></button>
        <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="location" src=""></iframe>
            </div>
        </div>
    </div>
</div>  
   



   

