@include("Site.header")
<style>
.error{
    color:red;
}
</style>
    <section>
        
        <div class="secondary-top">
            @if (session('status'))          
                <div class="alert alert-success">  
                    <a class="panel-close close" data-dismiss="alert">&times;</a>                
                    {{ session('status') }}
                </div>
            @endif
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    <fieldset>
                        <div class="col-xs-12">
                            <h1>Check Shipment Status</h1>
                            <form action="{{ url('user/webshipOrderTracking') }}" class="form-horizontal" method="POST" name="webshipOrderTracking" id="webshipOrderTracking">
                                {!! csrf_field() !!}  
                                <div class="form-group">
                                    <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="trackingNumber">Tracking Number <span class="important">*</span></label>  
                                    <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                        <input name="trackingNumber" type="text" id="trackingNumber" placeholder="Tracking Number" value="@if(!empty($trackingNumber)){{ $trackingNumber }}@elseif(old('trackingNumber')){{old('trackingNumber')}}@endif" maxlength="100" class="form-control input-md"> 

                                    </div>
                                    @if ($errors->has('trackingNumber'))
                                        <div class="error">{{ $errors->first('trackingNumber') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
                                    <div class="col-md-3 col-sm-6 col-xs-12 custom-btn">
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary" style="margin-top: 15px;">Check</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <?php if(!empty($trackingNumber)) { 
                            if($currentShipmentStatus == 1) { ?>
                                <table class="table" style="width: 50%;margin: 0 auto; margin-bottom: 2%;" border="1">
                                        <tr>
                                            <th>Tracking Number</th>
                                            <td>{{ $orderDetails->tracking_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Image</th>
                                            <td><img src="{{url('public/uploads/images/products/thumbnail/'.$orderDetails->pd_thumbnail) }}" alt="No Image"/></td>
                                        </tr>
                                        <tr>    
                                            <th>Product Name</th>
                                            <td>{{ $orderDetails->pd_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td>{{ $orderDetails->od_qty }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Of The Shipment</th>
                                            <td>Booked</td>
                                        </tr>
                                </table>
                            <?php } else { ?>
                                <p style="text-align:center;">Your shipment is not booked yet!</p> 
                            <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
    @php $base_url = \URL::to(''); @endphp
    <script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
    <script>
    $("#webshipOrderTracking").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.parents(".error-cls"));
        },
        rules: {
            'trackingNumber': {
              required: true,
            }
        },
        messages:{
            'trackingNumber': {
              required: "Please enter tracking number"
            }
        }
    });
     $("#webshipOrderTracking").find("button[type='submit']").on("submit",function(e){
        
        if($("#webshipOrderTracking").valid()) { 
            $(this).submit();
        } else {
            return false;
        }
    });
    </script>
    <script>
        setTimeout(function() {
         $('.alert-success').fadeOut();
        }, 5000 );
    </script>
</body>
</html>
