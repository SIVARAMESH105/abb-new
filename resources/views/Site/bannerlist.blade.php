@include("Site.header")
<div class="secondary-top">
		<div class="container container-md search-content">
            <div class="bg-white-section">
                <div class="row">
                    <div class="col-xs-12">
                    	<div><h2>Banner Lists</h2></div>
                    	<div><h3>Instructions<h3></div>
                    	<div>
                    		<ul>
                    			<li>Download the banner using "download" link and upload it into your website</li>
                    			<li>Copy the code from the text area box and paste it your website page which you provided URL links</li>
                    			<li>Update the image html element src path like "your_website_banner_image_path"</li>
                    			<li>Example: <blockquote><pre><code> img src="www.yourwebsite.com/banner_468x60.gif"</code></pre></blockquote></li>
                    		</ul>
                    	</div>
						<div class="table-responsive">
							<table class="table table-bordered display">
								<tbody>
									<tr>
										<td>Size</td>
										<td class="banners-a">Style</td>
										<td>Code (Copy for Ctrl+C)</td>
										<td>Action</td>
									</tr>
									<tr>
										<td><strong>468 x 60</strong></td>
										<td>Full Banner</td>
										<td><textarea id="myTextArea0" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_468x60.gif"/></a></textarea><button id="copy" data-id='0' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_468x60.gif')}}','enlarge','width=508,height=100,menubar=yes,status=yes')" title="View">View</a> | <a href="{{asset('public/banners/banner_468x60.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>728 x 90</strong></td>
										<td>Leaderboard</td>
										<td><textarea id="myTextArea1" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_728x90.gif"/></a></textarea><button id="copy" data-id='1' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_728x90.gif')}}','enlarge','width=768,height=130,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_728x90.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>336 x 280</strong></td>
										<td>Square</td>
										<td><textarea id="myTextArea2" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_336x280.gif"/></a></textarea><button id="copy" data-id='2' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_336x280.gif')}}','enlarge','width=376,height=320,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_336x280.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>300 x 250</strong></td>
										<td>Square</td>
										<td><textarea id="myTextArea3" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_300x250.gif"/></a></textarea><button id="copy" data-id='3' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_300x250.gif')}}','enlarge','width=340,height=290,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_300x250.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>250 x 250</strong></td>
										<td>Square</td>
										<td><textarea id="myTextArea4" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_300x250.gif"/></a></textarea><button id="copy" data-id='4' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_300x250.gif')}}','enlarge','width=290,height=290,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_300x250.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>160 x 600</strong></td>
										<td>Skyscraper</td>
										<td><textarea id="myTextArea5" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_160x600.gif"/></a></textarea><button id="copy" data-id='5' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_160x600.gif')}}','enlarge','width=200,height=640,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_160x600.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>120 x 600</strong></td>
										<td>Skyscraper</td>
										<td><textarea id="myTextArea6" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_120x600.gif"/></a></textarea><button id="copy" data-id='6' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_120x600.gif')}}','enlarge','width=160,height=640,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_120x600.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>120 x 240</strong></td>
										<td>Small Skyscraper</td>
										<td><textarea id="myTextArea7" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_120x240.gif"/></a></textarea><button id="copy" data-id='7' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_120x240.gif')}}','enlarge','width=160,height=280,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_120x240.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>240 x 400</strong></td>
										<td>Fat Skyscraper</td>
										<td><textarea id="myTextArea8" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_240x400.gif"/></a></textarea><button id="copy" data-id='8' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_240x400.gif')}}','enlarge','width=280,height=440,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_240x400.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>234 x 60</strong></td>
										<td>Half Banner</td>
										<td><textarea id="myTextArea9" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_234x60.gif"/></a></textarea><button id="copy" data-id='9' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_234x60.gif')}}','enlarge','width=274,height=100,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_234x60.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>180 x 150</strong></td>
										<td>Rectangle</td>
										<td><textarea id="myTextArea10" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_180x150.gif"/></a></textarea><button id="copy" data-id='10' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_180x150.gif')}}','enlarge','width=220,height=190,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_180x150.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>125 x 125</strong></td>
										<td>Square Button</td>
										<td><textarea id="myTextArea11" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_125x125.gif"/></a></textarea><button id="copy" data-id='11' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_125x125.gif')}}','enlarge','width=165,height=165,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_125x125.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>120 x 90</strong></td>
										<td>Button</td>
										<td><textarea id="myTextArea12" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_120x90.gif"/></a></textarea><button id="copy" data-id='12' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_120x90.gif')}}','enlarge','width=160,height=130,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_120x90.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>120 x 60</strong></td>
										<td>Button</td>
										<td><textarea id="myTextArea13" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_120x60.gif"/></a></textarea><button id="copy" data-id='13' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_120x60.gif')}}','enlarge','width=160,height=100,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_120x60.gif')}}" download title="Download">Download</a></td>	
									</tr>
									<tr>
										<td><strong>88 x 31</strong></td>
										<td>Button</td>
										<td><textarea id="myTextArea14" rows="5" cols="50" style="resize:none;overflow:hidden"><a href="{{url('/')}}/schedule?affcode={{$affiliate->affiliated_code}}"><img src="banner_88x31.gif"/></a></textarea><button id="copy" data-id='14' style="margin: 0px 15px 0px; float: right; position: absolute;">Copy</button></td>
										<td><a href="javascript:void(0)" onclick="window.open('{{asset('public/banners/banner_88x31.gif')}}','enlarge','width=128,height=71,menubar=yes,status=yes')">View</a> | <a href="{{asset('public/banners/banner_88x31.gif')}}" download title="Download">Download</a></td>	
									</tr>
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@include("Site.features")
@include("Site.footer")
<script>
	$(document).ready(function() {
		$('button').on('click', function () {
			const myId = $(this).attr('data-id');
			document.getElementById("myTextArea"+myId).select();
			document.execCommand('copy');
			$(this).text('Copied');
		});
	});
</script>
</body>
</html>