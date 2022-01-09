@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					@php echo $pageContent[0]->content; @endphp
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>
