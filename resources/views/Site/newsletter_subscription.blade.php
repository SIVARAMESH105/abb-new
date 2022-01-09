@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                  <section class="newsletter-page  ">
                    <h1>Newsletter Subscription</h1>
                     <div align="center" class="row newsletter-main">
                      <div class="col-md-12">
                        <h2 class="newsletter-head">Get notified about local camps.</h2>
                        <form name="ccoptin" class="form-horizontal" action="https://visitor.constantcontact.com/d.jsp" target="_blank" method="post">                    
                            <input type="hidden" name="m" value="1101857529536">
                            <input type="hidden" name="p" value="oi">
                            <div class="form-group">
                              <label class="col-md-4 col-sm-5 col-xs-12 control-label" for="add2"> Enter your e-mail to subscribe</label>  
                              <div class="col-md-3 col-sm-4 col-xs-12  error-cls">
                                <input type="text" name="ea" size="14" value="" class="form-control input-md">
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-12 news-button">
                                <input type="submit" name="go" value="Go" class="submit btn btn-primary" />
                              </div>
                            </div>
                        </form>
                        
                      </div>
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