<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items (ordered left) ========== -->
      <!-- ========================================================= -->

      <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->
		
		<!-- Edit profile -->
        @if (backpack_auth()->guest())
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
            @if (config('backpack.base.registration_open'))
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a></li>
			<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a></li>
			@endif
        @else
			<li><a href="{{ url('admin/change_password') }}"><i class="fa fa-tag"></i> <span>Change Password</span></a></li>
			<!--<li><a href="{{ url('admin/profile/1/edit') }}"><i class="fa fa-tag"></i> <span>Profile</span></a></li>-->
			<li><a href="{{ url('admin/edit_profile/'.backpack_auth()->user()->id) }}"><i class="fa fa-tag"></i> <span>Edit Profile</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
		@endif
		

       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>
