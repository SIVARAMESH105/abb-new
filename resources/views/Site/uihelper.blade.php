
<!DOCTYPE html>

<html lang="en">

<!-- <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <title>ABC-comp4D</title>
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/styles.css') }}">
</head> -->

<body>
        <section class="inner-pages">
        <header class="main-header fixed">
		@include("Site.header")			
            <div class="social-share-list">
                <a>
                    <div class="share-wrap visible-xs" id="shareWrap">
                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                    </div>
                </a>
                <div class="social-share" id="socialShare">
                    <a href="https://www.facebook.com/Advantagebasketball">
                        <div class="fb-wrap">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a>
                        <div class="twitter-wrap">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a>
                        <div class="insta-wrap">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a>
                        <div class="pinterest-wrap">
                            <i class="fa fa-pinterest" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a>
                        <div class="email-wrap">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <div class="secondary-top">
            <div class="bg-white-section">
                <h2 class="text-center">Ui elements for developer</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>This is a h1 tag</h1>
                        <h2>This is a h2 tag</h2>
                        <h3>This is a h3 tag</h3>
                        <p>This is a sample paragraph <a href="mailto:info@advantagebasketball.com">running link</a> lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eu tempor diam. Vivamus tincidunt nulla mauris. Donec gravida libero dignissim viverra pulvinar.</p>
                        <p><a>Monday</a> | <a>Tuesday</a> | <a>Wednesday</a> | <a>Thursday</a></p>
                        <p class="text-underline">This is text-underline</p>
                        <p class="text-center">This is text-center</p>
                        <p class="red-text">This is red text</p>
                        <hr>
                        <h2>Margin alignment utility classes</h2>
                        <p class="text-italic">use the following classes for margin, margin-top, margin-bottom.</p>
                        <pre>
                            .margin-10{
                                margin:10px;
                            }
                            .margin-20{
                                margin:20px;
                            }
                            .mt-10{
                                margin-top:10px;
                            }
                            .mt-20{
                                margin-top: 20px;
                            }
                            .mt-30{
                                margin-top: 30px;
                            }
                            .mb-10{
                                margin-bottom: 10px;
                            }
                            .mb-20{
                                margin-bottom: 20px;
                            }
                            .mb-25{
                                margin-bottom: 25px;
                            }
                            .mb-30{
                                margin-bottom: 30px;
                            }
                        </pre>
                        <hr>
                        <h2>Basic icons</h2>
                        <div class="row">
                            <div class="col-md-3">
                                <p>View icon</p>
                            </div>
                            <div class="col-md-3">
                                <a href="javascript:;" title="View" alt="View"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p>Download icon</p>
                            </div>
                            <div class="col-md-3">
                                <a href="javascript:;" title="Download" alt="Download"><i class="fa fa-arrow-down"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p>Remove icon</p>
                            </div>
                            <div class="col-md-3">
                                <a href="javascript:;" title="Remove" alt="Remove"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p></p>
                            </div>
                        </div>
                        <hr>
                        <h2>Form elements</h2>
                        <form class="form-horizontal" method="POST" name="contactform" id="contactform">
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Text input <span class="important">*</span></label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="realname" type="Text" id="realname" value="" size="30" maxlength="50" class="form-control input-md"> 
                              </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Email <span class="important">*</span></label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                              <input type="email" name="email" id="email" value="" size="30" maxlength="50" class="form-control input-md error">
                              <span id="email-error" class="error">Please enter email</span>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="gender">Radio button<span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label class="radio-inline" for="gender-0">
                                        <input type="radio" name="gender" id="gender-0" value="male" checked="checked"> Male
                                    </label>
                                    <label class="radio-inline" for="gender-1">
                                        <input type="radio" name="gender" id="gender-1" value="female"> Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="hearabout">Select input</label>
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input type="file" name="basketimages" id="basketimages" class="form-control input-md">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="hearabout">File     input</label>
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <select id="hearabout" name="hearabout" class="form-control input-md" >
                                    <option value="">Select</option>
                                    <option value="">Option1 </option>
                                    <option value="">Option2</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Textarea</label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                  <textarea name="comments" class="form-control input-md" value="{{ old('comments') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Textarea with no resize</label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                  <textarea name="comments" class="form-control input-md textarea-no-resize" value="{{ old('comments') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit">Button 1</label>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" id="submit" name="submit" class="btn btn-primary">Send to us</button>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit">Button 2</label>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" id="submit" name="submit" class="btn">Go</button>
                              </div>
                            </div>
                        </form>
                        <hr>
                        <div>
                            <h2>Datatables layout</h2>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered display">
                                    <thead>
                                        <tr>
                                            <th>Camp Name</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th>Group code</th>
                                            <th>Total Participants</th>
                                            <th>city</th>
                                            <th>Duration</th>
                                            <th>comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>
                                                                            <tr>
                                            <td>Arizona State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>Arizona</td>
                                            <td>2 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>California State Basketball Camp</td>
                                            <td>Feb 21, 2018</td>
                                            <td>Feb 27, 2018</td>
                                            <td>ABB078</td>
                                            <td>25</td>
                                            <td>California</td>
                                            <td>4 weeks</td>
                                            <td>Completed</td>
                                        </tr>
                                        <tr>
                                            <td>Alabama State Basketball Camp</td>
                                            <td>Feb 21, 2019</td>
                                            <td>Feb 27, 2019</td>
                                            <td>ABB078</td>
                                            <td>20</td>
                                            <td>Alabama</td>
                                            <td>4 weeks</td>
                                            <td>Upcoming</td>
                                        </tr>

                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        <hr>
                        <h2>Tabs</h2>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item active">
                            <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                          </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ultricies lorem non nibh tempus auctor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam dignissim felis sed finibus facilisis. Suspendisse potenti. Sed a commodo metus, eget semper neque. Vestibulum facilisis ac turpis quis tristique. Ut cursus aliquam neque eleifend vulputate. Pellentesque scelerisque purus massa, sit amet facilisis nunc tristique vel. Fusce porttitor arcu in nulla aliquet, et eleifend lectus porta. Morbi sed orci ultrices, cursus nisl ut, lobortis quam. Phasellus pulvinar lacus non nunc finibus rutrum. Nullam sollicitudin dui sit amet pulvinar sagittis. Pellentesque et congue lacus. Suspendisse facilisis mauris lacus. Nullam sit amet vulputate nunc, eu bibendum nisl.</p>
                          </div>
                          <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                              <p>Donec maximus est vel metus ullamcorper, eget rhoncus neque tristique. Duis felis urna, ullamcorper ac vestibulum hendrerit, eleifend ac elit. Fusce ac egestas urna, id aliquam sem. Suspendisse vitae massa a lectus rutrum gravida. Aliquam ut nunc nunc. Morbi egestas elit mauris, sit amet interdum enim posuere non. Proin tempor, nunc quis imperdiet convallis, ligula quam tempus felis, ac interdum risus ex eget turpis. Vivamus posuere egestas turpis, et facilisis lectus consequat pellentesque. Sed bibendum lacus eu lectus commodo, euismod finibus arcu vestibulum. Fusce ut aliquam velit, ut fringilla augue. Nam congue rhoncus ante vel dignissim. Duis pharetra ultrices lorem quis viverra.</p>
                          </div>
                          <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                              <p>In convallis magna in blandit eleifend. Quisque convallis augue id justo fringilla, eu tincidunt eros pharetra. Integer justo nibh, gravida nec massa nec, lacinia vehicula mauris. Aenean ac tincidunt turpis. Suspendisse volutpat risus a leo vestibulum porttitor. Vestibulum euismod pharetra quam, nec lobortis libero dapibus non. Donec interdum quam sit amet luctus blandit. Quisque bibendum eu enim et aliquam. Nam lectus odio, sodales sit amet consequat vitae, ultrices vel ante. Duis sit amet quam ultricies, venenatis augue a, eleifend dolor. Ut nibh nisi, vehicula ac commodo eu, tristique ac mi.</p>
                          </div>
                          <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                              <p>Proin ut molestie justo, a pellentesque sem. Aenean sit amet odio quam. Cras porta orci nec sagittis vulputate. Fusce rutrum metus ac massa luctus, ac rutrum justo commodo. Donec eget interdum mi, ut consectetur lorem. Aliquam sit amet sodales arcu, ut cursus lorem. Praesent rhoncus est dui. Nullam nec vulputate ligula. Nullam eget sem orci. Pellentesque et nisl vitae orci maximus cursus.</p>
                          </div>
                        </div>
                        <hr>
                        <h2>Table structure</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Camp Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Registered Date</th>
                                    <th>Cost</th>
                                    <th>Address</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Arizona State Basketball Camp</td>
                                    <td>Feb 21, 2018</td>
                                    <td>Feb 27, 2018</td>
                                    <td>ABB078</td>
                                    <td>25</td>
                                    <td>Arizona</td>
                                    <td>2 weeks</td>
                                    <td>Completed</td>
                                </tr>
                                <tr>
                                    <td>California State Basketball Camp</td>
                                    <td>Feb 21, 2018</td>
                                    <td>Feb 27, 2018</td>
                                    <td>ABB078</td>
                                    <td>25</td>
                                    <td>California</td>
                                    <td>4 weeks</td>
                                    <td>Completed</td>
                                </tr>
                                <tr>
                                    <td>Alabama State Basketball Camp</td>
                                    <td>Feb 21, 2019</td>
                                    <td>Feb 27, 2019</td>
                                    <td>ABB078</td>
                                    <td>20</td>
                                    <td>Alabama</td>
                                    <td>4 weeks</td>
                                    <td>Upcoming</td>
                                </tr>
                                <tr>
                                    <td>Arizona State Basketball Camp</td>
                                    <td>Feb 21, 2018</td>
                                    <td>Feb 27, 2018</td>
                                    <td>ABB078</td>
                                    <td>25</td>
                                    <td>Arizona</td>
                                    <td>2 weeks</td>
                                    <td>Completed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include("Site.footer")
        <!-- DataTables -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <!-- Bootstrap JavaScript -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script>
        $('#example').DataTable({
            processing: true,
            language: {
                 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
            }
        });
		setTimeout(function() {
		 $('.alert-success').fadeOut();
		 $('#name, #email, #msg, #origin').val('')
		}, 5000 );
	</script>
</body>

</html>
