@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md">
                <div class="bg-white-section">
                    <h1>Privacy</h1>
                    @php echo $pageContent[0]->content; @endphp
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>
