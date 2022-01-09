@include("Site.header")
        <div class="secondary-top">
            @php echo $pageContent[0]->content; @endphp
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
 
</body>
</html>
