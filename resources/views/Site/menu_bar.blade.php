<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

  
		@if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='')
			<div class="button-in-menu">
		        <div class="login-class hidden-lg logout-design"><a href="{{url('user/logout')}}">Logout</a></div>
		        <div class="login-class search-class hidden-lg">
			        <form  method="post" action ="{{url('page/search')}}" id="mobile-form">
			            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
				        <input type="search" name ="search" id="mobile-search" placeholder="Search" />
				        <input type="submit" alt="Submit" title="Submit" class="search-submit">
				    </form>
		        </div>
		    
	    @else
	    	<div class="button-in-menu">
		        <div class="login-class hidden-lg"><a href="{{url('login')}}">Customer Login</a></div>
		        <div class="login-class menu-register hidden-lg"><a href="{{url('schedule')}}">Register</a></div>
		        <div class="login-class search-class hidden-lg">
			        <form  method="post" action ="{{url('page/search')}}" id="mobile-form">
			            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
				        <input type="search" name ="search"  id="mobile-search" placeholder="Search" />
				        <input type="submit" alt="Submit" title="Submit" class="search-submit">
			        </form>
		        </div>
	    	</div>
	    @endif
	<ul class="nav navbar-nav" id="oneNav">
		<!--<li><a class="active" href="{{url('')}}">Home</a>-->
		</li>
		<li class="dropdown">
			<a href="{{url('about-us')}}" role="button" aria-haspopup="true" aria-expanded="false">About us</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<!--<li><a href="{{url('about-us')}}">About</a></li>-->
			<ul class="dropdown-menu">
				<li><a href="{{url('michael_hummel')}}">Founder Bio</a></li>
				<li><a href="{{url('staff')}}">Staff</a></li>
				<li><a href="{{url('staff_requirements')}}">Staff Requirements</a></li>
				<!--<li><a href="{{url('privacy')}}">Privacy</a></li>-->
				<li><a href="{{url('customer-service')}}">Customer Service Policies</a></li>
				<li><a href="{{url('volunteer')}}">Volunteer</a></li>
				<li><a href="{{url('positions')}}">Positions</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('basketball_camps')}}" role="button" aria-haspopup="true" aria-expanded="false">Camps</a><span data-toggle="dropdown" class="dropdown-toggle caret"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('coaching_methods')}}">Coaching Methods</a></li>
				<li><a href="{{url('key_concepts')}}">Key Concepts</a></li>
				<li><a href="{{url('goals')}}">Goals</a></li>
				<li><a href="{{url('guest_speakers')}}">Guest Speakers</a></li>
				<li><a href="{{url('training_agenda')}}">Daily Agenda</a></li>
				<li><a href="{{url('drills')}}">Drills</a></li>
				<li><a href="{{url('shootingcamp')}}">Shooting Camp</a></li>
				<li><a href="{{url('funky_friday')}}">Funky Friday</a></li>
				<li><a href="{{url('scholarships')}}">Scholarships</a></li>
			</ul>
		</li>
		<li class="dropdown"><a href="{{url('store')}}">Products</a></li>
		<li><a href="{{url('schedule')}}">Schedule</a></li>  
		<!-- <li><a href="{{url('try-outs')}}">Teams</a></li> -->
		<li class="dropdown">
			<a href="#" role="button" aria-haspopup="true" aria-expanded="false">Training</a> <span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('one-on-one')}}">One-On-One</a></li>
				<li><a href="{{url('shootingcamp')}}">Shooting Camp</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('info')}}" role="button" aria-haspopup="true" aria-expanded="false">Valuable Info</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('articles')}}">Articles</a></li>
				<li><a href="{{url('links')}}">Links</a></li>
				<li><a href="{{url('newsletter_subscription')}}">Newsletter Subscription</a></li>
			</ul>
		</li>
		<li><a href="{{url('faq')}}">FAQ's</a></li>
		<li class="dropdown">
			<a href="#" role="button" aria-haspopup="true" aria-expanded="false">Galleries</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('videos')}}">Videos</a></li>
                <li><a href="{{url('photos')}}">Photos</a></li>
				<li><a href="{{url('uploadPhotos')}}">Upload Image</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('parents')}}" role="button" aria-haspopup="true" aria-expanded="false">Info For Parents</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('letter_parents')}}">Letter To  Parents</a></li>
				<li><a href="{{asset('public/pdf/parent-player_pledge.pdf')}}" target="_blank">Pledge</a></li>
				<li><a href="{{url('safetyandsecurity')}}">Safety & Security</a></li>
				<li><a href="{{asset('public/pdf/medical_release.pdf')}}" target="_blank">Medical Release Form</a></li>
				<li><a href="{{asset('public/pdf/parental_release.pdf')}}" target="_blank">Parental Release Form</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('players')}}" role="button" aria-haspopup="true" aria-expanded="false">Info For Players</a> <span class="caret dropdown-toggle" data-toggle="dropdown"></span>
			<ul class="dropdown-menu">
				<li><a href="{{asset('public/pdf/parent-player_pledge.pdf')}}" target="_blank">Pledge</a></li>
    				<li><a href="{{url('sportsmanship')}}">Sportsmanship</a></li>
			</ul>
		</li>
		<li><a href="{{url('reviews')}}">Reviews</a></li>
		<li><a href="{{url('contact')}}">Contact</a></li>
		<!--<li><a href="{{url('schedule')}}">Camps</a></li>
		<li><a href="{{url('camp_locations')}}">Valuable Info</a></li>
		<li><a href="{{url('faq')}}">FAQ's</a></li>
		<li><a href="{{url('contact')}}">Contact</a></li>
		<li><a href="{{url('store')}}">Product Store</a></li>
		<li><a href="{{url('cart/cartPage')}}">Cart</a></li>
		<li><a href="{{url('checkout/checkoutPage')}}">Checkout</a></li>
		<li><a href="{{url('about-us')}}">Login</a></li>-->
	</ul>
</div>


<div class="collapse navbar-collapse navbar-collapse-mobile" id="bs-example-navbar-collapse-2">

  
		@if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='')
			<div class="button-in-menu">
		        <div class="login-class hidden-lg logout-design"><a href="{{url('user/logout')}}">Logout</a></div>
		        <div class="login-class search-class hidden-lg">
			        <form  method="post" action ="{{url('page/search')}}" id="mobile-form">
			            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
				        <input type="search" name ="search" id="mobile-search" placeholder="Search" />
				        <input type="submit" alt="Submit" title="Submit" class="search-submit">
				    </form>
		        </div>
		    
	    @else
	    	<div class="button-in-menu">
		        <div class="login-class hidden-lg"><a href="{{url('login')}}">Customer Login</a></div>
		        <div class="login-class menu-register hidden-lg"><a href="{{url('schedule')}}">Register</a></div>
		        <div class="login-class search-class hidden-lg">
			        <form  method="post" action ="{{url('page/search')}}" id="mobile-form">
			            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
				        <input type="search" name ="search"  id="mobile-search" placeholder="Search" />
				        <input type="submit" alt="Submit" title="Submit" class="search-submit">
			        </form>
		        </div>
	    	</div>
	    @endif
	<ul class="nav navbar-nav" id="oneNav">
		<!--<li><a class="active" href="{{url('')}}">Home</a>-->
		</li>
		<li class="dropdown">
			<a href="{{url('about-us')}}" role="button" aria-haspopup="true" aria-expanded="false">About us</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<!--<li><a href="{{url('about-us')}}">About</a></li>-->
			<ul class="dropdown-menu">
				<li><a href="{{url('michael_hummel')}}">Founder Bio</a></li>
				<li><a href="{{url('staff')}}">Staff</a></li>
				<li><a href="{{url('staff_requirements')}}">Staff Requirements</a></li>
				<!--<li><a href="{{url('privacy')}}">Privacy</a></li>-->
				<li><a href="{{url('customer-service')}}">Customer Service Policies</a></li>
				<li><a href="{{url('volunteer')}}">Volunteer</a></li>
				<li><a href="{{url('positions')}}">Positions</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('basketball_camps')}}" role="button" aria-haspopup="true" aria-expanded="false">Camps</a><span data-toggle="dropdown" class="dropdown-toggle caret"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('coaching_methods')}}">Coaching Methods</a></li>
				<li><a href="{{url('key_concepts')}}">Key Concepts</a></li>
				<li><a href="{{url('goals')}}">Goals</a></li>
				<li><a href="{{url('guest_speakers')}}">Guest Speakers</a></li>
				<li><a href="{{url('training_agenda')}}">Daily Agenda</a></li>
				<li><a href="{{url('drills')}}">Drills</a></li>
				<li><a href="{{url('shootingcamp')}}">Shooting Camp</a></li>
				<li><a href="{{url('funky_friday')}}">Funky Friday</a></li>
				<li><a href="{{url('scholarships')}}">Scholarships</a></li>
			</ul>
		</li>
		<li class="dropdown"><a href="{{url('store')}}">Products</a></li>
		<li><a href="{{url('schedule')}}">Schedule</a></li>  
		<!-- <li><a href="{{url('try-outs')}}">Teams</a></li> -->
		<li class="dropdown">
			<a href="#" role="button" aria-haspopup="true" aria-expanded="false">Training</a> <span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('one-on-one')}}">One-On-One</a></li>
				<li><a href="{{url('shootingcamp')}}">Shooting Camp</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('info')}}" role="button" aria-haspopup="true" aria-expanded="false">Valuable Info</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('articles')}}">Articles</a></li>
				<li><a href="{{url('links')}}">Links</a></li>
				<li><a href="{{url('newsletter_subscription')}}">Newsletter Subscription</a></li>
			</ul>
		</li>
		<li><a href="{{url('faq')}}">FAQ's</a></li>
		<li class="dropdown">
			<a href="#" role="button" aria-haspopup="true" aria-expanded="false">Galleries</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('videos')}}">Videos</a></li>
                <li><a href="{{url('photos')}}">Photos</a></li>
				<li><a href="{{url('uploadPhotos')}}">Upload Image</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('parents')}}" role="button" aria-haspopup="true" aria-expanded="false">Info For Parents</a><span data-toggle="dropdown" class="caret dropdown-toggle"></span>
			<ul class="dropdown-menu">
				<li><a href="{{url('letter_parents')}}">Letter To  Parents</a></li>
				<li><a href="{{asset('public/pdf/parent-player_pledge.pdf')}}" target="_blank">Pledge</a></li>
				<li><a href="{{url('safetyandsecurity')}}">Safety & Security</a></li>
				<li><a href="{{asset('public/pdf/medical_release.pdf')}}" target="_blank">Medical Release Form</a></li>
				<li><a href="{{asset('public/pdf/parental_release.pdf')}}" target="_blank">Parental Release Form</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="{{url('players')}}" role="button" aria-haspopup="true" aria-expanded="false">Info For Players</a> <span class="caret dropdown-toggle" data-toggle="dropdown"></span>
			<ul class="dropdown-menu">
				<li><a href="{{asset('public/pdf/parent-player_pledge.pdf')}}" target="_blank">Pledge</a></li>
    				<li><a href="{{url('sportsmanship')}}">Sportsmanship</a></li>
			</ul>
		</li>
		<li><a href="{{url('reviews')}}">Reviews</a></li>
		<li><a href="{{url('contact')}}">Contact</a></li>
		<!--<li><a href="{{url('schedule')}}">Camps</a></li>
		<li><a href="{{url('camp_locations')}}">Valuable Info</a></li>
		<li><a href="{{url('faq')}}">FAQ's</a></li>
		<li><a href="{{url('contact')}}">Contact</a></li>
		<li><a href="{{url('store')}}">Product Store</a></li>
		<li><a href="{{url('cart/cartPage')}}">Cart</a></li>
		<li><a href="{{url('checkout/checkoutPage')}}">Checkout</a></li>
		<li><a href="{{url('about-us')}}">Login</a></li>-->
	</ul>
</div>

