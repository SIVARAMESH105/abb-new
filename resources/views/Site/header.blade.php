<!DOCTYPE html>
<html lang="en">
    <head>        
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">

         @if(isset($pageContent))
            @if($pageContent[0]->meta_title != '') 
            <title>{{ucwords($pageContent[0]->meta_title)}}</title>
            <meta name="title" content="<?php echo ucwords($pageContent[0]->meta_title);?>">
            @else 
            <title>Advantage Basketball Camps</title>
            <meta name="title" content="Advantage Basketball Camps">
            @endif 
            @if($pageContent[0]->meta != '')
            <meta name="description" content="<?php echo (strip_tags($pageContent[0]->meta));?>">
            @else
             <meta name="description" content="">
            
            @endif
            
        @endif
        <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
        <link rel="stylesheet" href="{{ asset('public/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/responsive.dataTables.min.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ URL::asset('public/css/jquery-alert/jquery-confirm.min.css') }}" />
        <link href="{{ asset('public/css/jquery-ui.css')}}" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('public/css/styles.css') }}">
        <style type="text/css">
            .complete{
            display:none;
            }
            .more{
            cursor: pointer;
            }
        </style>
    </head>
    <body @if(isset($_SESSION['cur_user_id']) || isset($username))class="sessionbody"@endif>
		@if(isset($social_links)==1)
			@if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='')
				<section class="inner-pages">
			@else
				<section class="top">
			@endif
		@else
			<section class="inner-pages">
		@endif
        <header class="main-header fixed desktop-view-menu">
			@if(isset($social_links)==1)
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
			@endif
            <div class="container container-sm">
                <div class="header-wrap">
                    <div class="logo-image-wrap">
                        <a href="{{url('/')}}"><img src="{{ asset('public/images/logo-image.png') }}" alt="Advantage Basketball Camps"></a>
                    </div>
                    <?php 
                        $user = Auth::user();
                        $id = Auth::id();
                        //echo $id;die;
                        //echo $_SESSION['cur_user_id'];die; ?>
                    <ul class="header-right-links">

                        @if((isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='') || isset($username) || session()->has('cur_user_id'))
                            {{-- Check login user is affiliator --}}
                            @if(session()->has('user_type') && Session::get('user_type') == 5) 
                                <li class="login-class visible-lg-block logout-design"><a href="{{url('affliate/logout')}}">Logout</a></li>
                            @else
                                <li class="login-class visible-lg-block logout-design"><a href="{{url('user/logout')}}">Logout</a></li>
                            @endif
                            <li class="login-class search-class visible-lg-block">
                                <form  method="post" action ="{{url('page/search')}}" id="web-form">
                                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                    <input type="search" id="search" name ="search" placeholder="Search" />
                                    <input type="submit" alt="Submit" id="web-submit" title="Submit" class="search-submit">
                                </form>
                            </li>
                            <!-- <li><a href="{{url('user/logout')}}" style="margin-left: 50%; color: white;">Logout</a></li>
                                <li><a href="{{url('user/editProfile')}}" style="margin-left: 50%; color: white;">Edit Profile</a></li>
                                <li><a href="{{url('user/regCamps')}}" style="margin-left: 50%; color: white;">Camps</a></li>
                                <li><a href="{{url('user/userGroups')}}" style="margin-left: 50%; color: white;">Groups</a></li>
                                <li><a href="{{url('user/purchaseProducts')}}" style="margin-left: 50%; color: white;">Orders</a></li> -->
                        @else
                            <li class="login-class visible-lg-block"><a href="{{url('login')}}">Customer Login</a></li>
                            <li class="login-class menu-register visible-lg-block"><a href="{{url('schedule')}}">Register</a></li>
                            <li class="login-class search-class visible-lg-block">
                                <form  method="post" action ="{{url('page/search')}}" id="web-form">
                                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                    <input type="search" id="search" name ="search" placeholder="Search" />
                                    <input type="submit" alt="Submit" id="web-submit" title="Submit" class="search-submit">
                                </form>
                            </li>
                        @endif
                    </ul>
                    <div class="logo-desc-wrap">
                        <a href="{{url('/')}}"><img src="{{ asset('public/images/logo-title.png') }}" alt="Advantage Basketball Camps"></a>
                        <p class="hidden-xs">Youth Basketball Training Camps for Kids Ages 5-18</p>
                        <p class="telephone"><img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone">425-670-8877</p>
                       <p class="header-mail"><img src="{{ asset('public/images/mail-envelope.png') }}" alt="mail">info@advantagebasketball.com</p> 
                    </div>
                </div>
                <div class="navbar-header">
                    <!-- <div class="mobile-icon">
                        <a href="tel:425-670-8877" title="phone">
                            <img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone">
                        </a>
                        <a href="mail-to:425-670-8877" title="phone">
                            <img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone">
                        </a>      
                    </div> -->  
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="sr-only">Toggle navigation</span>
                    </button>
                    <!-- <button type="button" class="toggle-btn"><a href="#" class="arrow"></a></button> -->
                </div>
            </div>
            <div class="nav-wrap">
                <div class="container container-sm">
                    <nav class="navbar navbar-default">
                        @include("Site.menu_bar")
                    </nav>
                </div>
            </div>
            @if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='' && Request::segment(1))
            <div class="back-to-dashbaord">
                <div class="container container-sm">
                    <a href="{{ url('/') }}">Back To Dashboard </a>
                </div>
            </div>
            @endif
			@if(isset($username))
			<div class="back-to-dashbaord">
		         <div class="container container-sm">
		           <a href="{{url('/')}}/affiliate/dashboard">Back To Dashboard </a>
		        </div>
		    </div>
			@endif
        </header>
        <header class="main-header fixed mobile-view-menu">
            @if(isset($social_links)==1)
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
            @endif
            <div class="container container-sm">
                <div class="header-wrap">
                    <div class="logo-image-wrap">
                        <a href="{{url('/')}}"><img src="{{ asset('public/images/logo-image.png') }}" alt="Advantage Basketball Camps" class="main-logo"></a>
                        <a href="{{url('/')}}"><img src="{{ asset('public/images/logo-title.png') }}" alt="Advantage Basketball Camps" class="secondary-logo"></a>
                    </div>
                    <?php 
                        $user = Auth::user();
                        $id = Auth::id();
                        //echo $id;die;
                        //echo $_SESSION['cur_user_id'];die; ?>
                    <ul class="header-right-links">

                        @if((isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='') || isset($username) || session()->has('cur_user_id'))
                            {{-- Check login user is affiliator --}}
                            @if(session()->has('user_type') && Session::get('user_type') == 5) 
                                <li class="login-class visible-lg-block logout-design"><a href="{{url('affliate/logout')}}">Logout</a></li>
                            @else
                                <li class="login-class visible-lg-block logout-design"><a href="{{url('user/logout')}}">Logout</a></li>
                            @endif
                            <li class="login-class search-class visible-lg-block">
                                <form  method="post" action ="{{url('page/search')}}" id="web-form">
                                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                    <input type="search" id="search" name ="search" placeholder="Search" />
                                    <input type="submit" alt="Submit" id="web-submit" title="Submit" class="search-submit">
                                </form>
                            </li>
                            <!-- <li><a href="{{url('user/logout')}}" style="margin-left: 50%; color: white;">Logout</a></li>
                                <li><a href="{{url('user/editProfile')}}" style="margin-left: 50%; color: white;">Edit Profile</a></li>
                                <li><a href="{{url('user/regCamps')}}" style="margin-left: 50%; color: white;">Camps</a></li>
                                <li><a href="{{url('user/userGroups')}}" style="margin-left: 50%; color: white;">Groups</a></li>
                                <li><a href="{{url('user/purchaseProducts')}}" style="margin-left: 50%; color: white;">Orders</a></li> -->
                        @else
                            <li class="login-class visible-lg-block"><a href="{{url('login')}}">Customer Login</a></li>
                            <li class="login-class menu-register visible-lg-block"><a href="{{url('schedule')}}">Register</a></li>
                            <li class="login-class search-class visible-lg-block">
                                <form  method="post" action ="{{url('page/search')}}" id="web-form">
                                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                    <input type="search" id="search" name ="search" placeholder="Search" />
                                    <input type="submit" alt="Submit" id="web-submit" title="Submit" class="search-submit">
                                </form>
                            </li>
                        @endif
                    </ul>
                    <div class="logo-desc-wrap">
                     
                        <p class="hidden-xs">Youth Basketball Training Camps for Kids Ages 5-18</p>
                        <p class="telephone"><img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone"></p>
                       <p class="header-mail"><img src="{{ asset('public/images/mail-envelope.png') }}" alt="mail"></p> 
                    </div>
                </div>
                <div class="navbar-header">
                    <!-- <div class="mobile-icon">
                        <a href="tel:425-670-8877" title="phone">
                            <img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone">
                        </a>
                        <a href="mail-to:425-670-8877" title="phone">
                            <img src="{{ asset('public/images/phone-icon.png') }}" alt="Phone">
                        </a>      
                    </div> -->  
                    <button type="button" class="navbar-toggle collapsed nav-icon-mobile" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="sr-only">Toggle navigation</span>
                    </button>
                    <!-- <button type="button" class="toggle-btn"><a href="#" class="arrow"></a></button> -->
                </div>
            </div>
            <div class="nav-wrap">
                <div class="container container-sm">
                    <nav class="navbar navbar-default">
                        @include("Site.menu_bar")
                    </nav>
                </div>
            </div>
            @if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='' && Request::segment(1))
            <div class="back-to-dashbaord">
                <div class="container container-sm">
                    <a href="{{ url('/') }}">Back To Dashboard </a>
                </div>
            </div>
            @endif
            @if(isset($username))
            <div class="back-to-dashbaord">
                 <div class="container container-sm">
                   <a href="{{url('/')}}/affiliate/dashboard">Back To Dashboard </a>
                </div>
            </div>
            @endif
        </header>