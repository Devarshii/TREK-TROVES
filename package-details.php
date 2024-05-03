<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Trek Troves</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
					<script>
						$(document).ready(function(){

						  $(".img-container").popupLightbox();

						});
					</script>

<link rel="stylesheet" href="css/font-awesome.min.css">
<link href="css/animate.min.css" rel="stylesheet" />

<script src="js/jquery.popup.lightbox.js"></script>
<link href="css/popup-lightbox.css" rel="stylesheet">


	  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.img-container img {
   width: 200px;
   height: auto;
   border-radius: 5px;
   cursor: pointer;
   -webkit-tap-highlight-color: transparent;
   transition: .3s;
  -webkit-transition: .3s;
  -moz-transition: .3s;

}
.img-container img:hover{
  transform: scale(0.97);
 -webkit-transform: scale(0.97);
 -moz-transform: scale(0.97);
 -o-transform: scale(0.97);
  opacity: 0.75;
 -webkit-opacity: 0.75;
 -moz-opacity: 0.75;
  transition: .3s;
 -webkit-transition: .3s;
 -moz-transition: .3s;
}
.img-show img {
	width: unset !important;
}
		</style>				
</head>
<body>
<!-- top-header -->
<?php include('includes/header.php');?>
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> Trek Troves -Package Details</h1>
	</div>
</div>
<?php $sql = "SELECT packageId, packageImage from tbltourpackageimages";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$packageImages = array();
if ($query->rowCount() > 0) {
	foreach ($results as $result) {
		$packageImages[$result->packageId][] = $result->packageImage;
	}
}
?>
<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		<?php if($error) { ?>
			<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
		<?php } else if($msg) { ?>
			<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
		<?php } ?>
		<?php 
		$pid = intval($_GET['pkgid']);
		$sql = "SELECT * from tbltourpackages where PackageId=:pid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':pid', $pid);
		$query->execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
		if($query->rowCount() > 0) {
			foreach($results as $result) { ?>
				<form name="book" method="post" action="package_place_order.php">
					<input type="hidden" name="packageId" value="<?php echo $result->PackageId; ?>">
					<div class="selectroom_top">
						<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
								
								<?php if(!empty($packageImages[$result->PackageId])) { ?>
									<center>
									<div id="myCarousel" class="carousel slide" data-ride="carousel">
										<div class="img-container">
										    <!-- Indicators -->
										    <ol class="carousel-indicators">
										    	<?php for($i = 0; $i < count($packageImages[$result->PackageId]); $i++) { 
										    		$extraClass = ($i == 0) ? 'class="active"' : ''; ?>
										      		<li data-target="#myCarousel" data-slide-to="0" <?php echo $extraClass; ?>></li>
										      	<?php } ?>
										    </ol>

										    <!-- Wrapper for slides -->
										    <div class="carousel-inner">
										    	<?php for($i = 0; $i < count($packageImages[$result->PackageId]); $i++) { 
										    		$extraActiveClass = ($i == 0) ? 'active' : ''; ?>
										    		<div class="item <?php echo $extraActiveClass; ?>">
												        <img src="admin/packageImages/<?php echo htmlentities($packageImages[$result->PackageId][$i]);?>" alt="" >
												    </div>
												<?php } ?>
										    </div>

										    <!-- Left and right controls -->
										    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
										    	<span class="glyphicon glyphicon-chevron-left"></span>
										    	<span class="sr-only">Previous</span>
										    </a>
										    <a class="right carousel-control" href="#myCarousel" data-slide="next">
										    	<span class="glyphicon glyphicon-chevron-right"></span>
										    	<span class="sr-only">Next</span>
										    </a>
										</div>
								  	</div>
								  	</center>
								<?php } ?>
						</div>
						<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
							<h2><?php echo htmlentities($result->PackageName);?></h2>
							<p class="dow">#PKG-<?php echo htmlentities($result->PackageId);?></p>
							<p><b>Package Type :</b> <?php echo htmlentities($result->PackageType);?></p>
							<p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
							<p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>
							<div class="ban-bottom">
								<div class="bnr-right">
									<label class="inputLabel">Package Dates</label>
									<?php $timings = !empty($result->PackageTimings) ? json_decode($result->PackageTimings, true) : array(); 
									if(!empty($timings)) { ?>
										<select name="tourTimings">
											<?php foreach($timings as $timing) { ?>
												<option value="<?php echo $timing['startDate'] . '_' . $timing['endDate']; ?>"><?php echo $timing['startDate'] . ' to ' . $timing['endDate']; ?></option>
											<?php } ?> 
										</select>
									<?php } ?>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="grand">
								<p>Grand Total</p>
								<h3>INR.<?php echo htmlentities($result->PackagePrice);?></h3>
							</div>
						</div>
						<h3>Package Details</h3>
						<p style="padding-top: 1%; text-align: justify;"><?php echo nl2br(htmlentities($result->PackageDetails));?> </p>	
						<div class="clearfix"></div>
					</div>
					<div class="selectroom_top">
						<h2>Travels</h2>
						<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
							<ul>
							
								<li class="spe">
									<label class="inputLabel">Comment</label>
									<input class="special" type="text" name="comment" required="">
								</li>
								<?php if($_SESSION['login'])
								{?>
									<li class="spe" align="center">
								<button type="submit" name="submit2" class="btn-primary btn">Book</button>
									</li>
									<?php } else {?>
										<li class="sigi" align="center" style="margin-top: 1%">
										<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn" > Book</a></li>
										<?php } ?>
								<div class="clearfix"></div>
							</ul>
						</div>
						
					</div>
				</form>
			<?php }
		} ?>
	</div>
</div>
<!--- /selectroom ---->
<<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>
</body>
</html>