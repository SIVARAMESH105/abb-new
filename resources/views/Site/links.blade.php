@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    <h1>Links</h1>
                    <div class="link-section">
                    @php echo $pageContent[0]->content; @endphp
                    </div>                   
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>