@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    <h1>Articles</h1>
                    <ul>
                        <li><a href="{{url('key_concepts')}}">Read an article on the key training concepts that produce excellent basketball players</a></li>
                        <li><a href="{{url('muscle_memory')}}">Read how &quot;Muscle Memory&quot; is such an important part of learning the game</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
</body>
</html>