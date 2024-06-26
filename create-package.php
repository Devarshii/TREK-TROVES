<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
	header('location:index.php');
} 
else
{
	if(isset($_POST['submit']))
	{
		$pname = $_POST['packagename'];
		$ptype = $_POST['packagetype'];	
		$plocation = $_POST['packagelocation'];
		$pprice = $_POST['packageprice'];	
		$pfeatures = $_POST['packagefeatures'];
		$pdetails = $_POST['packagedetails'];

		$timings = array();
		for($i = 0; $i < 5; $i++) {
			if(!empty($_POST['startDate'][$i]) && !empty($_POST['endDate'][$i])) {
				$tmp['startDate'] = $_POST['startDate'][$i];
				$tmp['endDate'] = $_POST['endDate'][$i];
				$timings[] = $tmp;
			}
		}

		$sql="INSERT INTO tbltourpackages(PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures, PackageDetails, PackageTimings) VALUES(:pname, :ptype, :plocation, :pprice, :pfeatures, :pdetails, :packageTimings)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':pname', $pname);
		$query->bindParam(':ptype', $ptype);
		$query->bindParam(':plocation', $plocation);
		$query->bindParam(':pprice', $pprice);
		$query->bindParam(':pfeatures', $pfeatures);
		$query->bindParam(':pdetails', $pdetails);
		$query->bindParam(':pdetails', $pdetails);
		$query->bindParam(':packageTimings', json_encode($timings));
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			$msg="Package Created Successfully";
		}
		else 
		{
			$error="Something went wrong. Please try again";
		}
	}

	?>
	<!DOCTYPE HTML>
	<html>
		<head>
		<title>Trek Troves | Admin Package Creation</title>

		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css"/>
		<link href="css/font-awesome.css" rel="stylesheet"> 
		<script src="js/jquery-2.1.4.min.js"></script>
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<link rel="stylesheet" href="css/jquery-ui.css" />
		<script src="js/jquery-ui.js"></script>
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
		</style>
	</head> 
	<body>
	  <div class="page-container">
	   	<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>
					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Package </li>
				</ol>
				<!--grid-->
				<div class="grid-form">
					<div class="grid-form1">
						<h3>Create Package</h3>
						<?php if($error) { ?>
							<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php 
						} else if($msg) { ?>
							<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
						<?php } ?>

						<div class="tab-content">
							<div class="tab-pane active" id="horizontal-form">
								<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Create Package" required>
										</div>
									</div>
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" name="packagetype" id="packagetype" placeholder=" Package Type eg- Family Package / Couple Package" required>
										</div>
									</div>

									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Location</label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder=" Package Location" required>
										</div>
									</div>

									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Price in INR</label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" name="packageprice" id="packageprice" placeholder=" Package Price is INR" required>
										</div>
									</div>

									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Features</label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" name="packagefeatures" id="packagefeatures" placeholder="Package Features Eg-free Pickup-drop facility" required>
										</div>
									</div>		

									<div class="form-group">
										<div class="col-sm-2">
											<label for="focusedinput" class="control-label">Package Timings</label>
										</div>
										<div class="col-sm-8 row">
											<?php for($i = 0; $i < 5; $i++) { ?>
												<div class="col-sm-8">
													<div class="col-sm-6">
														<input type="text" class="form-control1 datepicker" name="startDate[]" placeholder="Start date">
													</div>
													<div class="col-sm-6">
														<input type="text" class="form-control1 datepicker" name="endDate[]" placeholder="End date">
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Details</label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="5" cols="50" name="packagedetails" id="packagedetails" placeholder="Package Details" required></textarea> 
										</div>
									</div>

									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button type="submit" name="submit" class="btn-primary btn">Create</button>

											<button type="reset" class="btn-inverse btn">Reset</button>
										</div>
									</div>
								</form>
							</div>

							<div class="panel-footer"></div>
						</div>
					</div>
					<script>
						$(document).ready(function() {
						 	var navoffeset=$(".header-main").offset().top;
						 	$(window).scroll(function(){
								var scrollpos=$(window).scrollTop(); 
								if(scrollpos >=navoffeset){
									$(".header-main").addClass("fixed");
								}else{
									$(".header-main").removeClass("fixed");
								}
							});

							$('.datepicker').datepicker({
								dateFormat: 'yy-mm-dd',
								minDate: 0
							});
						});
					</script>

					<div class="inner-block"></div>

					<?php include('includes/footer.php');?>
				</div>
				<?php include('includes/sidebarmenu.php');?>
				<div class="clearfix"></div>
			</div>
			<script>
				var toggle = true;				
				$(".sidebar-icon").click(function() {          
				  if (toggle)
				  {
						$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
						$("#menu span").css({"position":"absolute"});
				  }
				  else
				  {
						$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
						setTimeout(function() {
						  $("#menu span").css({"position":"relative"});
						}, 400);
				  }
				  toggle = !toggle;
				});
			</script>
			<!--js -->
			<script src="js/jquery.nicescroll.js"></script>
			<script src="js/scripts.js"></script>
			<!-- Bootstrap Core JavaScript -->

			<script src="js/bootstrap.min.js"></script>
			<!-- /Bootstrap Core JavaScript -->	   
		</body>
	</html>
<?php } ?>