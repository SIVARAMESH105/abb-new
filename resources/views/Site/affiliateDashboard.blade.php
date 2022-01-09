@include("Site.header")			
<div class="secondary-top" style="background:white;">
	<div class="bg-white-section">
		<section class="dashboard-view-section" >
			<div class ="container container-sm search-content">
				<div class="dashboard-container">
					<h3>{{ $username }}</h3>
					<div class="row">
						<div class="col-sm-6 col-md-4 text-center">
							<div class="dashboard-types">
								<a href="{{url('affiliate/banner')}}" class="dashboard-types-view">
									 <img src="{{asset('images/dashboard-registration.png')}}">
									 <p>Banner Graphics Download</p>
								 </a>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-center">
							<div class="dashboard-types">
								<a href="{{url('affiliate/commission')}}" class="dashboard-types-view">
									 <img src="{{asset('images/dashboard-groups.png')}}">
									 <p>Affiliate Commission Status</p>
								 </a>
							</div>
						</div>
						<div class="col-sm-6 col-md-4 text-center">
							<div class="dashboard-types">
								<a href="{{url('affiliate/userlists')}}" class="dashboard-types-view">
									 <img src="{{asset('images/dashboard-registration.png')}}">
									 <p>User Lists</p>
								 </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
@include("Site.features")
@include("Site.footer")
</body>
</html>
