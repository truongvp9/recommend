@extends('help')
@extends('layouts.app')

<!--
Author: W3layouts
Author URL: http://w3layouts.coms
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>All Videos</title>
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
<script src="js/bootstrap.min.js"></script>
<!-- fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Patrick+Hand+SC|Spectral" rel="stylesheet">
<script type="text/javascript" src="js/modernizr.custom.min.js"></script>    
<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<!-- //fonts -->
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
				<h3 class="slogan-title" >CHƯƠNG TRÌNH GIỚI THIỆU PHIM TỰ ĐỘNG</h3>
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
                                                <a id="sampledata" class="help">Tìm kiếm phim tại đây</a>
						<img src="/images/13.png" id="help" class="helper">
                                                <input type="text" class="form-control has-tooltip" title="Tìm kiếm phim tại đây	" placeholder="Search..." name="key">
						<input type="submit" value=" ">
					</form>
				</div>
			</div>
		</div>
	</nav>
	<!-- NAVBAR END -->
	<!-- MAIN BEGIN -->
	<div class="container-fluid main-wrapper">
		<script>
		</script>
		
		<div class="row">
			<!-- LEFT BEGIN -->
			<div class="main col-lg-11 col-md-9">
				<div class="clearfix text-center">
					<form method="POST" id="frecommend" action="/recommend">
						{{ csrf_field() }}	
						<input type="hidden" id="irecommend" name="irecommend" value=""/>
					</form>
                                        <a id="sampledata1" class="help1">Sau khi chọn khoảng 5 phim hãy click vào nút Recommend để nhận gợi ý</a>
					<button title="Sau khi chọn khoảng 5 phim hãy click vào nút Recommend để nhận gợi ý" class="btn btn-success has-tooltip" id="btn_recommend"> Recommend</button>
					
				</div>
				<div class="page-header">
					<div class="row">
                				<div class="col-sm-4">
                                                        <a id="sampledata2" class="help2">Đây là danh sách videos, Bạn hãy chọn bộ phim bạn đã xem và đánh giá </a>
							<h2 class="has-tooltip" title="Đây là danh sách videos, Bạn hãy chọn bộ phim bạn đã xem và đánh giá ">All Videos</h2>
						</div>
						<div class="col-sm-8 text-right">
							<ul class="pagination">{{ $item->links() }}</ul>
						</div>
					</div>
				</div>
				<?php if ($page <=0) { ?>
				<a href="javascript:;" class="page-nav page-prev disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
				<?php } else { ?>
				<a href="index.php?page=<?= $page-1 ?>" class="page-nav page-prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				<?php } ?>
				<?php if ($next) { ?>
				<a href="index.php?page=<?= $page+1 ?>" class="page-nav page-next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				<?php } else { ?>
				<a href="javascript:;" class="page-nav page-next disabled"><span class="glyphicon glyphicon-chevron-next"></span></a>
				<?php } ?>
				
				<div class="main-grids">
					<div class="clearfix top-grids">
						<?php foreach ($item as $i=>$value):?>
						<div class="resent-grid slider-top-grids">
							<div class="resent-grid-img bxslider">
								<a href="/movies/<?=$value->id;?>"><img src="https://image.tmdb.org/t/p/w500/<?php echo $value->Image;?>" alt="" /></a>
								<div class="time"><p>3:04</p></div>
								<div class="clck">
									<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
								</div>
							</div>
							<div class="resent-grid-info">
								<h4><a href="/movies/<?=$value->id;?>" class="title title-info"><?php echo $value->MovieName;?></a><br></h4>
								<p class="author"><?php echo $value->getCategory($value->id);?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<!-- LEFT END -->
			<div class="main col-lg-1 col-md-3">
                                <a id="sampledata3" class="help3">Đây là danh sách các phim bạn đã đánh giá </a>
				<h5 class="has-tooltip" title="Đây là danh sách các phim bạn đã đánh giá">History</h5>
				<a class='btn btn-danger' href='/deleteallhistory/1'>Clear History</a>
				<br>
				<br>
				<?php foreach ($rate as $mov) { ?>
				<div class="single-right-grids">
					<div class="single-right-grid-left">
						<a href="/movies/<?= $mov->id;?>">
							<img class="media-object mov-img" src="https://image.tmdb.org/t/p/w500/<?= $mov->Image;?>">
						</a>
						<small>	<?=$mov->getRate($mov->id);?> </small>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- MAIN END -->
</body>
</html>
<script language="javascript">
$(document).ready(function(){
  //$('.bxslider').bxSlider();
  console.log({{Auth::id()}});
  user = {{Auth::id()}};
  $('#btn_recommend').click(function(){
		//alert('click');
		$.ajax({
			url:'http://localhost:8002/queries.json',
			type: 'POST',
			dataType: 'json',
			contentType: 'application/json',
			processData : false,
			data : '{ "user":"'+user+'", "num": 500, "ratingFlag": 0 }',
			success: function(data){
                                $('#irecommend').val(JSON.stringify(data));
				console.log("Data:",JSON.stringify(data));
                                $('#frecommend').submit();		
			},
			error: function(err){
				alert("Error: Cannot get data",err);		
			}	
		});
	})
});
</script>
