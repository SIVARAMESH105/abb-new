	@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md ">
                <div class="bg-white-section">
					@if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image custom-{{$pageContent[0]->title}}">
							<img src="{{ asset('public/uploads/images/cms/'.$pageContent[0]->image1) }}" alt="">
						</div>
					@endif
                    <section class="with-sidebar-layout">
						<div class="content-body-wrap search-content">
							@php echo $pageContent[0]->content; @endphp
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
							@php echo $pageContent[0]->sidebar; @endphp
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>
