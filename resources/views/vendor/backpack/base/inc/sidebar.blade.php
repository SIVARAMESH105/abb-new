@if (backpack_auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(backpack_auth()->user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ backpack_auth()->user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
			<li class="header">{{ trans('backpack::base.administration') }}</li>
			<!-- ================================================ -->
			<!-- ==== Recommended place for admin menu items ==== -->
			<!-- ================================================ -->
			<!-- Admin menus -->
			@if(backpack_auth()->user()->user_type == 1)
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/viewRosters') }}"><i class="fa fa-dashboard"></i> <span>View Rosters</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageCampers') }}"><i class="fa fa-dashboard"></i> <span>Manage Campers</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageCoaches') }}"><i class="fa fa-dashboard"></i> <span>Manage Coaches</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageCamps') }}"><i class="fa fa-dashboard"></i> <span>Manage Camps</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageLocations') }}"><i class="fa fa-dashboard"></i> <span>Manage Location</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageCountry') }}"><i class="fa fa-dashboard"></i> <span>Manage Country</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageState') }}"><i class="fa fa-dashboard"></i> <span>Manage State</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageAssignments') }}"><i class="fa fa-dashboard"></i> <span>Assignments</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageProducts') }}"><i class="fa fa-dashboard"></i> <span>Manage Product</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageColors') }}"><i class="fa fa-dashboard"></i> <span>Manage Colors</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageFlyers') }}"><i class="fa fa-dashboard"></i> <span>Manage Flyers</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/orders') }}"><i class="fa fa-dashboard"></i> <span>Registration & Order</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/cms') }}"><i class="fa fa-dashboard"></i> <span>Manage CMS</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/staffbios') }}"><i class="fa fa-dashboard"></i> <span>Staff Bios</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/videoGallery') }}"><i class="fa fa-dashboard"></i> <span>Video Gallery</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/imagesGallery') }}"><i class="fa fa-dashboard"></i> <span>Image Gallery</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageGroups') }}"><i class="fa fa-dashboard"></i> <span>Manage Groups</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/reports') }}"><i class="fa fa-dashboard"></i> <span>Reports</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageDirectors') }}"><i class="fa fa-dashboard"></i> <span>Manage Directors</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageAffiliate') }}"><i class="fa fa-dashboard"></i> <span>Manage Affiliate</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/affiliateReports') }}"><i class="fa fa-dashboard"></i> <span>Affiliate Reports</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/trackWebShipment') }}"><i class="fa fa-dashboard"></i> <span>Track WebShipments</span></a></li>
			<!-- Coach menus -->
			@elseif(backpack_auth()->user()->user_type == 2)
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/viewCoachRosters/'.backpack_auth()->user()->id.'/'.backpack_auth()->user()->user_type) }}"><i class="fa fa-dashboard"></i> <span>View Rosters</span></a></li>
			<!-- Director menus -->
			@elseif(backpack_auth()->user()->user_type == 4)
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/manageCoaches') }}"><i class="fa fa-dashboard"></i> <span>Manage Coaches</span></a></li>
				<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/reports') }}"><i class="fa fa-dashboard"></i> <span>Reports</span></a></li>
			@endif
          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
