@include("Site.header")

        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
                        <div class="banner-wrap header-image">
                            <img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
                        </div>
                    @endif
                    <?php echo $pageContent[0]->content; ?>
                    <section class="with-sidebar-layout">
                        <div class="content-body-wrap">
                            <div class="col-xs-12 ">
                                <div class="title">
                                    <h1>Advantage Basketball Camps Schedule</h1>
                                </div>
                                <div class="each-advantage">
                                    <h2>Youth Sports Camps With A Positive Difference</h2>
                                    <p>This is a list of camps currently scheduled. Please scroll down to view the current list. We may be adding new location/camps and will post them here as soon as they are confirmed. Please do not call and ask if a camp is coming to your area if you do not see it below. Feel free to send an e-mail and ask about camps in your area if you wish.</p>

                                    <div class="scrollto-section">
                                        <div class="scroll-content">
                                            <h4>Scroll down to view camps</h4>
                                        </div>
                                        <div class="scroll-img">
                                            <a class="camps-link" href="#camps"> <img src="{{ asset('public/images/schedule-scroll.png') }}" alt="Scrollto-camps" title="Scroll-to-camps"> </a>
                                        </div>
                                    </div>
                                    <p>If you would like to host a camp in your area as a fund raiser for your school, then please e-mail your request to us and we will be happy to bring our world-renowned program to your school.</p>
                                    
                                    <p>We have three types of camps: Shooting, Ball-Handling, and "Specialty Camps". The Specialty Camps are an advanced camp covering a wide range of topics from defense to offense, court awareness, shooting and more. Specialty camps will only happen over Winter and Spring Break each year.</p>
                                    
                                </div>
                                <div class="title" id="camps">
                                    <h2>Find a Camp</h2>
                                </div>
                                <div class="each-advantage" >
                                   <p class="red-text camp-desc">More camps coming soon! If you don't see a camp in your area, check back soon or contact us for more information. Or, enter your e-mail address in the left column (below the "View Camps" button) and we'll notify you about new camps.
                                    </p>
                                </div>
                                <section class="">
                                    <form action="" class="form-horizontal schedule-camp-view col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" name="viewcamps" id="allcamps"/>
                                            <label class=" control-label" for="allcamps">View all camps</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" name="viewcamps" id="viewbylocation" />
                                            <label class="control-label" for="viewbylocation">Find Camps by location</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" name="viewcamps" id="viewbydate"/>
                                            <label class="control-label" for="viewbydate">Find Camps by Date</label>
                                        </div>
                                        <div id="locationfilter" class="filterform">
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">State</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select id="state_val" name="country" class="form-control input-md">
                                                        <option>Select a state</option>
                                                        @foreach($state_details as $state)
                                                            <option value="{{$state->state_id}}" >{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">City</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12" id='testing123'>
                                                    <select class="form-control input-md" id="city_list" disabled>
                                                       <option>Select a city</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">Month</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select class="form-control input-md"
                                                    id="month_list" disabled>
                                                        <option>Select a month</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3 col-sm-4 col-xs-12"></div>
                                                <div class="col-md-4 col-sm-6 col-xs-12" >
                                                    <button type="submit" style="color: black; background: red; font-weight: bold;" class="form-control input-md" id="campsByLocationBtn" disabled>Find my camp</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="datefilter" class="filterform">
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">Month</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select class="form-control input-md" id="month_list1">
                                                        <option>Select a month</option>
                                                          @foreach($camp_startdate as $camp_start)
                                                               
                                                            <option value="{{$value = DateTime::createFromFormat('F-d-Y', $camp_start->camp_startdate)->format('Y-m-d')}}" >{{$value = DateTime::createFromFormat('F-d-Y', $camp_start->camp_startdate)->format('F Y')}}</option>
                                                        @endforeach
                                                       
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">State</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select class="form-control input-md" id="state_list" disabled>
                                                        <option>Select a state</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-4 col-xs-12  control-label" for="selectbasic">City</label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <select class="form-control input-md" id="city_list1" disabled>
                                                       <option>Select a city</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3 col-sm-4 col-xs-12"></div>
                                                <div class="col-md-4 col-sm-6 col-xs-12" >
                                                    <button type="button" style="color: black; background: red; font-weight: bold;" class="form-control input-md" id="campsByDateBtn" disabled>Find my camp</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                
                                        <div class="form-group camp-group" id="camplist">
                                          
                                        </div>
                                    </form>   
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
                                </section>
                            </div>
                            
                        </div>
                        <div class="side-bar-wrap">
                        <form name="ccoptin" class="form-horizontal" method="post" action="https://visitor.constantcontact.com/d.jsp" target="_blank" method="post">                    
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
                            @php echo $pageContent[0]->sidebar; @endphp
                        </div>
                            
                    </section>

                    
                </div>
            </div>
        </div>
    @include("Site.features")
    @include("Site.footer")
    @php $base_url = \URL::to(''); @endphp
    <script>
    // $('#country_val').change(function() { 
    //  var cid = $('#country_val').val();
    //  var b_url = '{{url("/")}}';
    //  window.location.href = b_url+"/camp/countrySort/"+cid;
    // });
    </script>
    <script>
    $(document).ready(function(){

        

        $('.filterform').hide();
       // $('#camplist').hide();
        $('[name="viewcamps"]').on('change click', function(){
            var campfilterid = $(this).attr('id');
            if (campfilterid == "allcamps")  {
                $('#camplist').empty();
                $('.filterform').hide();
            } else if (campfilterid == "viewbylocation" || "viewbydate" ){
                $('#camplist').empty();
                if (campfilterid == "viewbylocation") {
                    $('.filterform').hide();
                    $('#locationfilter').show();
                } else {
                    $('.filterform').hide();
                    $('#datefilter').show();
                }
            }
        });

        // $(".more").click(function(){
        //         alert();exit;
        //     $(this).text("less..").siblings(".complete").show();    
        // }, function(){
        //     $(this).text("more..").siblings(".complete").hide();    
        // });
    });
  

    /* Script state on change */
    $(document).on('change','#state_val',function(){
        var state_id = $(this).val();
        var newOption = $('<option>Select a city</option>');

        $('#city_list').prop('disabled', false).empty().append(newOption);
        $('#month_list').empty().append('<option>Select a month</option>');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxGetCity') }}",
            data: { stateId: state_id},
            dataType: 'JSON',
            success: function(data) {
                var toAppend = '';
                $.each(data,function(key, val){
                    toAppend += '<option value="' + val.City + '">'+val.City+'</option>';
                });
                $('#city_list').append(toAppend); 
            }
        });
    });
    /* Script to get month on change */
    $(document).on('change','#city_list',function(){
        var city_id = $(this).val();
        var state_id = $('#state_val').val();
      
        $('#month_list').prop('disabled', false).empty().append('<option>Select a month</option>');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxMonthList') }}",
            data: { stateId: state_id, cityId: city_id},
            dataType: 'JSON',
            success: function(data) {

                var toAppend = '';
                $.each(data,function(key, val){
                    toAppend += '<option value="' + val.startdate + '">'+val.startCamp+'</option>';
                });
                $('#month_list').append(toAppend); 
                    
            }

        });
    });
    $(document).on('change','#month_list',function(){
        $('#campsByLocationBtn').prop('disabled', false);
    });
    /* list camp by location*/
    $(document).on('click','#campsByLocationBtn',function(event){
        event.preventDefault();

        

        var state_id = $('#state_val').val();
        var city = $('#city_list').val();
        var month = $('#month_list').val();
        $('#camplist').empty();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxGetCamps') }}",
            data: { stateId: state_id, cityId: city, month:month},
            dataType: 'JSON',
            success: function(data) {
                var toAppend = '';
                var structedData = '';
                if(data.length == 0){
                     toAppend += '<div><h4>'+'No camps found'+'<h4></div>';
                }
                else{ 
                     var state_cmp = '';
                    $.each(data,function(key, val){
                        var earlyDis = '';
                        var register ="{{ url('camp/register') }}/"+val.id;
                        if(val.EarlyBirdDiscount != 0){
                            if( val.today < val.save) {
                                var earlyDis = '<span style="color:#FF0000">Save $'+val.EarlyBirdDiscount+' if you register before ' +val.save+'!</span>';   
                            }
                        }

                        toAppend += '<div class="search-results">';
                        if(state_cmp != val.state_name){
                            toAppend += '<h2>'+val.state_name+'</h2>';
                        }else{
                            toAppend += '<br>';
                        }
                        toAppend +='<p><b>'+val.City+', '+val.state_name+'</b></p><p>'+val.camp_focus+'</p><p>'+val.startCamp+' - '+ val.endCamp+'</p><span class="more">View more details...</span><span class="complete">'+val.starttime +' to '+ val.endtime+'<p>'+val.Address+','+ val.City+' '+val.Zip+'</p><p>'+val.Location+'<a class="campmap" href="https://www.google.com/maps?q='+val.Address+','+ val.City+' '+val.Zip+','+val.Location+'&output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a> </p>Cost: $'+val.cost+'</p>'+earlyDis+'<p>Contact:'+val.contact+'</p><p><a href="'+register+'">Register now</a></p></p></span></div>';
                        
                        structedData += '{"@context":"http://schema.org","@type":"ChildrensEvent","description":"Advantage Basketball Camps in Bellingham, Washington during Summer 2019, featuring Ball Handling and Basketball Shooting training.","image":"{{ URL::to('/') }}/images/featured_image.jpg","location":{"@type":"Place","address":{"@type":"PostalAddress","streetAddress":"'+val.Address+'","addressLocality":"'+ val.City+'","addressRegion":"'+val.state_name+'","postalCode":"'+val.Zip+'","addressCountry":"'+val.country_code+'"},"name":"'+val.Location+'"},"name":"'+val.camp_focus+'","offers":{"@type":"Offer","availability":"http://schema.org/LimitedAvailability","availabilityEnds":"2019-08-01T09:00","offeredBy":{"@type":"Corporation","contactPoint":{"@type":"ContactPoint","areaServed":"US","contactType":"Sales","email":"info@advantagebasketball.com","telephone":"+1-425-670-8877"},"address":{"@type":"PostalAddress","postOfficeBoxNumber":"1344","addressLocality":"Lynnwood","addressRegion":"WA","postalCode":"98046","addressCountry":"'+val.country_code+'"},"identifier":{"@type":"PropertyValue","propertyID":"UBI","value":"601600614"},"image":"{{ URL::to('/') }}/public/images/logo-image.png","legalName":"Hummel Enterprises, Inc.","name":"Advantage Basketball Camps","sameAs":"https://www.linkedin.com/company/advantage-basketball-camps","telephone":"+1-425-670-8877","url":"{{ URL::to('/') }}"},"price":"'+val.cost+'","priceCurrency":"USD","url":"{{ URL::to('/') }}/camp/register/'+val.id+'"},"startDate":"'+val.startdate+'T'+val.starttime+'","endDate":"'+val.enddate+'T'+val.endtime+'","typicalAgeRange":"6-18"}';
                        state_cmp = val.state_name;

                    });
                }
                
                $('#camplist').append(toAppend);                
                var jsonStructureData = document.createElement('script');
                jsonStructureData.setAttribute('type', 'application/ld+json');
                jsonStructureData.innerHTML = structedData;
                $('#camplist').append(jsonStructureData); 
                    
            }

        });

    });

    /*Listing all camps*/
    $(document).on('click','#allcamps',function(event){
        /* refreshing select option */
        var select = "state_val,month_list1";
        $.each(select.split(","), function(i,e){
            $("#"+e).val($("#"+e+" option:first").val());
        });
       
        var select1 = "city_list,month_list,city_list1,state_list";
        $.each(select1.split(","), function(i,e){
            var val = e.split('_');
            $("#"+e).empty().append('<option>Select a '+val[0]+' </option>').prop('disabled', true);
        });
       
        $('#campsByDateBtn').prop('disabled', true);
        $('#campsByLocationBtn').prop('disabled', true);
        /* refreshing select option end*/

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxAllCamps') }}",
            dataType: 'JSON',
            success: function(data) {
                //alert(data);die;
                var toAppend = '';
                var structedData = '';
                if(data.length == 0){
                     toAppend += '<div><h4>'+'No camps found'+'<h4></div>';
                }
                else{ 
                    var state_cmp = '';
                    $.each(data,function(key, val){
                        var earlyDis = '';
                        var register ="{{ url('camp/register') }}/"+val.id;
                        if(val.EarlyBirdDiscount > 0){
                            if( val.today < val.save) {
                                var earlyDis = '<span style="color:#FF0000">Save $'+val.EarlyBirdDiscount+' if you register before ' +val.save+'!</span>';   
                            }
                        }
                        toAppend += '<div class="search-results">';
                        if(state_cmp != val.state_name){
                            toAppend += '<h2>'+val.state_name+'</h2>';
                        }else{
                            toAppend += '<br>';
                        }   
                        toAppend += '<p><b>'+val.City+', '+val.state_name+'</b></p><p>'+val.camp_focus+'</p><p>'+val.startCamp+' - '+ val.endCamp+'</p><span class="more">View more details...</span><span class="complete">'+val.starttime +' to '+ val.endtime+'<p>'+val.Address+','+ val.City+' '+val.Zip+'</p><p>'+val.Location+'<a class="campmap" href="https://www.google.com/maps?q='+val.Address+','+ val.City+' '+val.Zip+','+val.Location+'&output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a> </p>Cost: $'+val.cost+'</p>'+earlyDis+'<p>Contact:'+val.contact+'</p><p><a href="'+register+'">Register now</a></p></p></span></div>';

                        structedData += '{"@context":"http://schema.org","@type":"ChildrensEvent","description":"Advantage Basketball Camps in Bellingham, Washington during Summer 2019, featuring Ball Handling and Basketball Shooting training.","image":"{{ URL::to('/') }}/images/featured_image.jpg","location":{"@type":"Place","address":{"@type":"PostalAddress","streetAddress":"'+val.Address+'","addressLocality":"'+ val.City+'","addressRegion":"'+val.state_name+'","postalCode":"'+val.Zip+'","addressCountry":"'+val.country_code+'"},"name":"'+val.Location+'"},"name":"'+val.camp_focus+'","offers":{"@type":"Offer","availability":"http://schema.org/LimitedAvailability","availabilityEnds":"2019-08-01T09:00","offeredBy":{"@type":"Corporation","contactPoint":{"@type":"ContactPoint","areaServed":"US","contactType":"Sales","email":"info@advantagebasketball.com","telephone":"+1-425-670-8877"},"address":{"@type":"PostalAddress","postOfficeBoxNumber":"1344","addressLocality":"Lynnwood","addressRegion":"WA","postalCode":"98046","addressCountry":"'+val.country_code+'"},"identifier":{"@type":"PropertyValue","propertyID":"UBI","value":"601600614"},"image":"{{ URL::to('/') }}/public/images/logo-image.png","legalName":"Hummel Enterprises, Inc.","name":"Advantage Basketball Camps","sameAs":"https://www.linkedin.com/company/advantage-basketball-camps","telephone":"+1-425-670-8877","url":"{{ URL::to('/') }}"},"price":"'+val.cost+'","priceCurrency":"USD","url":"{{ URL::to('/') }}/camp/register/'+val.id+'"},"startDate":"'+val.startdate+'T'+val.starttime+'","endDate":"'+val.enddate+'T'+val.endtime+'","typicalAgeRange":"6-18"}';
                        state_cmp = val.state_name;
                    });
                }
                        

                $('#camplist').append(toAppend);
                var jsonStructureData = document.createElement('script');
                jsonStructureData.setAttribute('type', 'application/ld+json');
                jsonStructureData.innerHTML = structedData;
                $('#camplist').append(jsonStructureData);   
            }

        });

    });
    /* view more detail*/
    


    /* Find Camp By Date */
    $(document).on('change','#month_list1',function(){
        var month = $(this).val();
        //alert($month);
        var newOption = $('<option>Select a state</option>');

        $('#state_list').prop('disabled', false).empty().append(newOption);
        $('#city_list1').empty().append('<option>Select a city</option>');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxGetState') }}",
            data: { month: month},
            dataType: 'JSON',
            success: function(data) {
                if(data.length != 0){
                    var toAppend = '';
                    $.each(data,function(key, val){
                        toAppend += '<option value="' +val.state_id+ '">'+val.state_name+'</option>';
                    });
                    $('#state_list').append(toAppend); 
                }
            }
        });
    });

    $(document).on('change','#state_list',function(){
        var state_id = $(this).val();
        var month = $('#month_list1').val();

        $('#city_list1').prop('disabled', false).empty().append('<option>Select a city</option>');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('ajaxCityByDate') }}",
            data: { month: month, stateId:state_id },
            dataType: 'JSON',
            success: function(data) {
                //alert(data);exit;
                if(data.length != 0){
                    var toAppend = '';
                    $.each(data,function(key, val){
                        toAppend += '<option value="' +val.City+ '">'+val.City+'</option>';
                    });
                    $('#city_list1').append(toAppend); 
                }
            }
        });
    });

    $(document).on('change','#city_list1',function(){
        $('#campsByDateBtn').prop('disabled', false);
    });

    $(document).on('click','#campsByDateBtn',function(event){
        event.preventDefault();

       


        var state_id = $('#state_list').val();
        var city = $('#city_list1').val();
        var month = $('#month_list1').val();
        $('#camplist').empty();

        $.ajax({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           type: 'GET',
           url: "{{ route('ajaxCampsByDate') }}",
           data: { stateId: state_id, cityId: city, month:month},
           dataType: 'JSON',
           success: function(data) {
            //alert(data);exit;
               var toAppend = '';
               var structedData = '';
               if(data.length == 0){
                    toAppend += '<div><h4>'+'No camps found'+'<h4></div>';
               }
               else{ 
                   var state_cmp = '';
                   $.each(data,function(key, val){
                       var earlyDis = '';
                       var register ="{{ url('camp/register') }}/"+val.id;
                       if(val.EarlyBirdDiscount > 0){
                            if( val.today < val.save) {
                                var earlyDis = '<span style="color:#FF0000">Save $'+val.EarlyBirdDiscount+' if you register before ' +val.save+'!</span>';   
                            }
                       }

                       toAppend += '<div class="search-results">';

                        if(state_cmp != val.state_name){
                            toAppend += '<h2>'+val.state_name+'</h2>';
                        } else{
                            toAppend += '<br>';
                        }
                     
                       toAppend += '<p><b>'+val.City+', '+val.state_name+'</b></p><p>'+val.camp_focus+'</p><p>'+val.startCamp+' - '+ val.endCamp+'</p><span class="more">View more details...</span><span class="complete">'+val.starttime +' to '+ val.endtime+'<p>'+val.Address+','+ val.City+' '+val.Zip+'</p><p>'+val.Location+'<a class="campmap" href="https://www.google.com/maps?q='+val.Address+','+ val.City+' '+val.Zip+','+val.Location+'&output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a> </p>Cost: $'+val.cost+'</p>'+earlyDis+'<p>Contact:'+val.contact+'</p><p><a href="'+register+'">Register now</a></p></p></span></div>';
                       state_cmp = val.state_name;

                       structedData += '{"@context":"http://schema.org","@type":"ChildrensEvent","description":"Advantage Basketball Camps in Bellingham, Washington during Summer 2019, featuring Ball Handling and Basketball Shooting training.","image":"{{ URL::to('/') }}/images/featured_image.jpg","location":{"@type":"Place","address":{"@type":"PostalAddress","streetAddress":"'+val.Address+'","addressLocality":"'+ val.City+'","addressRegion":"'+val.state_name+'","postalCode":"'+val.Zip+'","addressCountry":"'+val.country_code+'"},"name":"'+val.Location+'"},"name":"'+val.camp_focus+'","offers":{"@type":"Offer","availability":"http://schema.org/LimitedAvailability","availabilityEnds":"2019-08-01T09:00","offeredBy":{"@type":"Corporation","contactPoint":{"@type":"ContactPoint","areaServed":"US","contactType":"Sales","email":"info@advantagebasketball.com","telephone":"+1-425-670-8877"},"address":{"@type":"PostalAddress","postOfficeBoxNumber":"1344","addressLocality":"Lynnwood","addressRegion":"WA","postalCode":"98046","addressCountry":"'+val.country_code+'"},"identifier":{"@type":"PropertyValue","propertyID":"UBI","value":"601600614"},"image":"{{ URL::to('/') }}/public/images/logo-image.png","legalName":"Hummel Enterprises, Inc.","name":"Advantage Basketball Camps","sameAs":"https://www.linkedin.com/company/advantage-basketball-camps","telephone":"+1-425-670-8877","url":"{{ URL::to('/') }}"},"price":"'+val.cost+'","priceCurrency":"USD","url":"{{ URL::to('/') }}/camp/register/'+val.id+'"},"startDate":"'+val.startdate+'T'+val.starttime+'","endDate":"'+val.enddate+'T'+val.endtime+'","typicalAgeRange":"6-18"}';
                   });
               }
               $('#camplist').append(toAppend);
                              
                var jsonStructureData = document.createElement('script');
                jsonStructureData.setAttribute('type', 'application/ld+json');
                jsonStructureData.innerHTML = structedData;
                $('#camplist').append(jsonStructureData);       
           }

       });
    });

    $(document).on('click','#viewbydate',function(event){
        /* refreshing select option */
        $("#state_val").val($("#state_val option:first").val());
       
        var select1 = "city_list,month_list";
        $.each(select1.split(","), function(i,e){
            var val = e.split('_');
            $("#"+e).empty().append('<option>Select a '+val[0]+' </option>').prop('disabled', true);
        });
         $('#campsByLocationBtn').prop('disabled', true);
        /* refreshing select option end*/

    });
    $(document).on('click','#viewbylocation',function(event){
        /* refreshing select option */
        $("#month_list1").val($("#month_list1 option:first").val());
       
        var select1 = "city_list1,state_list";
        $.each(select1.split(","), function(i,e){
            var val = e.split('_');
            $("#"+e).empty().append('<option>Select a '+val[0]+' </option>').prop('disabled', true);
        });
        $('#campsByDateBtn').prop('disabled', true);
        /* refreshing select option end */
    });  
    $(document).on('click','.campmap', function(event){
            var mapsrc = $(this).attr('href');
            $('#location').attr('src'," ");
            $('#location').attr('src',mapsrc);
    });
    </script>
</body>
</html>