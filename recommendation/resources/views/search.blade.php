@extends('help')
@extends('layouts.app')

<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Recommend System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="My Play Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' media="all" />
<!-- //bootstrap -->
<link href="css/dashboard.css" rel="stylesheet">
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' media="all" />
<script src="/js/jquery-1.11.1.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Spectral" rel="stylesheet">
<!-- fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
<!-- //fonts -->
<style>
	.page-nav {
		position: absolute;
		display: table;
		font-size: 20px;
		background-color: rgba(0,0,0,.3);
		color: #ccc;
		top: 40%;
		padding: 10px;
		border-radius: 22px;
		z-index: 10000;
		margin: 0 20px;
	}
	.page-nav:hover {
		color: #fff;
	}
	.page-nav.disabled {
		background-color: rgba(0,0,0,.1);
	}
	.page-prev {
		left: 0;
	}
	.page-next {
		right: 0;
	}
</style>
</head>
<body>
	<!-- HAVBAR BEGIN -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><h1><img width="50" src="images/vp9.jpg" alt="" /></h1></a>
			</div>
			<div class="slogan" id="slogan">
				<h3 class="slogan-title">CHƯƠNG TRÌNH GIỚI THIỆU PHIM TỰ ĐỘNG</h3>
				<div><strong>Bước 1</strong></div>
				<div>Hãy đánh giá các phim bạn đã xem bên dưới (càng nhiều càng tốt)</div>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<!-- LOGOUT BEGIN -->
				<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
						<li><a href="{{ route('login') }}">Login</a></li>
						<li><a href="{{ route('register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<ul class="dropdown-menu" id="logout-menu" role="menu">
								<li>
									<a href="{{ route('logout') }}"
									    onclick="event.preventDefault();
									             document.getElementById('logout-form').submit();">
									    Logout
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									    {{ csrf_field() }}
									</form>
								</li>
							</ul>
							<a onclick="document.getElementById('logout-menu').style.display='block';" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							    {{ Auth::user()->name }} <span class="caret"></span>
							</a>
						</li>
					@endif
				</ul>
				<!-- LOGOUT END -->
				<div class="navbar-right top-search">
					<form class="navbar-form navbar-right" action="/search" method="post">
						{{ csrf_field() }}
						<input type="text" class="form-control has-tooltip" title="Tìm kiếm phim tại đây	" placeholder="Search..." name="key">
						<input type="submit" value=" ">
					</form>
				</div>
			</div>
		</div>
	</nav>
	<!-- NAVBAR END -->
	
        
        <div class="col-sm-12 main">
        	<?php if ($page <=0) { ?>
			<a href="javascript:;" class="page-nav page-prev disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<?php } else { ?>
			<a href="search?key=<?= $key ?>&page=<?= $page-1 ?>" class="page-nav page-prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<?php } ?>
			<?php if ($next) { ?>
			<a href="search?key=<?= $key ?>&page=<?= $page+1 ?>" class="page-nav page-next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			<?php } else { ?>
			<a href="javascript:;" class="page-nav page-next disabled"><span class="glyphicon glyphicon-chevron-next"></span></a>
			<?php } ?>
			<div class="main-grids">
				<div class="top-grids">
					<div class="recommended-info">
						<h3>All Videos</h3>
					</div>
                                        <?php foreach ($item as $i=>$value):?>
                                        	<?php if ($i%5 == 0) { ?>
                                        	<div class="clearfix"></div>
                                        	<?php } ?>
                                            <div class="<?= $i%5==0?'col-sm-2 col-sm-offset-1':'col-sm-2' ?> resent-grid recommended-grid slider-top-grids">
                                                    <div class="resent-grid-img recommended-grid-img bxslider">
                                                            <a href="/movies/<?=$value->id;?>"><img src="https://image.tmdb.org/t/p/w500/<?php echo $value->Image;?>" alt="" /></a>
                                                            <div class="time">
                                                                    <p>3:04</p>
                                                            </div>
                                                            <div class="clck">
                                                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                                            </div>
                                                    </div>
                                                    <div class="resent-grid-info recommended-grid-info">
                                                            <h3><a href="/movies/<?=$value->id;?>" class="title title-info"><?php echo $value->MovieName;?></a></h3>
                                                    </div>
                                            </div>
                                        <?php endforeach; ?>
					<div class="clearfix"> </div>
				</div>
				
			</div>
			<!-- footer -->
			
			<!-- //footer -->
		</div>
		<div class="clearfix"> </div>
	<div class="drop-menu">
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu4">
		  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Regular link</a></li>
		  <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Disabled link</a></li>
		  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another link</a></li>
		</ul>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
  </body>
</html>
<script language="javascript">
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
$(document).ready(function(){
  $('.bxslider').bxSlider();
});
</script>
