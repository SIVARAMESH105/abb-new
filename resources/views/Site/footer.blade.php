<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12 footer-wrap">
				<p class="footer-title">Advantage Basketball Camps</p>
				<p>P.O. Box 1344</p>
				<p>Lynnwood, WA 98046</p>
				<p>Phone: 425-670-8877</p>
				<p>Email: <a class="text-underline" href="mailto:&#032;&#105;&#110;&#102;&#111;&#064;&#097;&#100;&#118;&#097;&#110;&#116;&#097;&#103;&#101;&#098;&#097;&#115;&#107;&#101;&#116;&#098;&#097;&#108;&#108;&#046;&#099;&#111;&#109;&#032;">&#032;&#105;&#110;&#102;&#111;&#064;&#097;&#100;&#118;&#097;&#110;&#116;&#097;&#103;&#101;&#098;&#097;&#115;&#107;&#101;&#116;&#098;&#097;&#108;&#108;&#046;&#099;&#111;&#109;&#032;</a>
			</div>
		</div>
		<div class="row copyright-info">
			<div class="col-sm-6 col-xs-12">
				<p>&copy; Copyright 2002 - <span id="yearC"></span> , Advantage Basketball Camps - All rights reserved.</p>
			</div>
			<div class="col-sm-6 col-xs-12">
				<p>  <a  href="http://www.newtechweb.com" target="_blank">Website design,hosting and maintenance by New Tech Web, Inc.</a></p>
			</div>
		</div>
	</div>
</footer>

<script src="{{ asset('public/js/jquery.min.js')}}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/owl.carousel.js') }}"></script>
<script src="{{ asset('public/js/scripts.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
<script>
	
    $(document).on('click','.more',function(){
        $(this).text('').siblings(".complete").show();
    });

    $(document).ready(function(){
        $('#search').keypress(function (e) {
            
            if(e.which == 13)  // the enter key code
            {
               $("#web-form").submit();
               return false;  
            }
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0   && e.which != 45  && e.which != 39 && e.which != 32   && (e.which < 48 || e.which > 57 && (e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90))) {
              //display error message
               return false;
            }

        });
        $('#mobile-search').keypress(function (e) {

            if(e.which == 13)  // the enter key code
            {
               $("#mobile-form").submit();
               return false;  
            }
            if (e.which != 8 && e.which != 0   && e.which != 45  && e.which != 39 && e.which != 32   && (e.which < 48 || e.which > 57 && (e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90))) {
              //display error message
               return false;
            }

        });
		
		/*Listing all camps*/
		$("#web-form,#mobile-form").submit(function(){
			var dessearch = $('#search').val();
			var mobsearch = $('#mobile-search').val();
			if (dessearch == '' && mobsearch==''){
				alert('Please enter characters to search!');
				return false;
			}
			if(dessearch.length>0) {
				search_value = dessearch;
				
			} else {
				search_value = mobsearch;

			}

		});

    });

$(document).on('click','.campmap', function(event){
            var mapsrc = $(this).attr('href');
            $('#location').attr('src'," ");
            $('#location').attr('src',mapsrc);
    });
</script>