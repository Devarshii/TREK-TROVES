<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
	header('location:index.php');
} else {
	if(isset($_POST['submit'])) {
		$name = $_POST['name'];
		$price_per_day = $_POST['price_per_day'];	
		$detail = $_POST['detail'];	
		$image = time() . $_FILES["equipmentImage"]["name"];
		move_uploaded_file($_FILES["equipmentImage"]["tmp_name"], "equipmentImages/" . $image);
		$sql = "INSERT INTO tblequipments (name, price_per_day, detail, equipmentImage, status) VALUES(:name, :price_per_day, :detail, :image, 1)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':name',$name,PDO::PARAM_STR);
		$query->bindParam(':price_per_day',$price_per_day,PDO::PARAM_STR);
		$query->bindParam(':detail',$detail,PDO::PARAM_STR);
		$query->bindParam(':image',$image,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$msg="Equipment Created Successfully";
			header("location:manage-equipments.php");
		} else {
			$error="Something went wrong. Please try again";
		}
	} ?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<title>Trek Troves | Admin Equipment Creation</title>

		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css"/>
		<link href="css/font-awesome.css" rel="stylesheet"> 
		<script src="js/jquery-2.1.4.min.js"></script>
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
				<div class="left-content">
		   		<div class="mother-grid-inner">
		   			<?php include "includes/header.php"; ?>	
					  <div class="clearfix"> </div>
					</div>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Equipment</li>
					</ol>
					<div class="grid-form">
						<div class="grid-form1">
	  	       	<h3>Create Equipment</h3>
	  	       	<?php if ($error) { ?>
	  	       		<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
	  	       	<?php } elseif ($msg) { ?>
	  	       		<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
	  	       	<?php } ?>
	  	       	<div class="tab-content">
	  	       		<div class="tab-pane active" id="horizontal-form">
									<form class="form-horizontal" name="equipment" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Equipment Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control1" name="name" id="name" placeholder="Name" required>
											</div>
										</div>

										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Price Per Day</label>
											<div class="col-sm-8">
												<input type="text" class="form-control1" name="price_per_day" id="price_per_day" placeholder="Price Per Day" required>
											</div>
										</div>

										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Equipment Details</label>
											<div class="col-sm-8">
												<textarea class="form-control" rows="5" cols="50" name="detail" id="detail" placeholder="Equipment Details" required></textarea>
											</div>
										</div>

										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Equipment Image</label>
											<div class="col-sm-8">
												<input type="file" name="equipmentImage" id="equipmentImage" required>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button type="submit" name="submit" class="btn-primary btn">Create</button>
											</div>
										</div>
									</form>
									<div class="panel-footer"></div>
								</div>
							</div>

							<div class="inner-block">
							</div>

							<?php include "includes/footer.php"; ?>
						</div>
					</div>
					<?php include "includes/sidebarmenu.php"; ?>
					<div class="clearfix"></div>		
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
					 
				});
			</script>
			<script>
				var toggle = true;
							
				$(".sidebar-icon").click(function() {                
				  if (toggle) {
						$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
						$("#menu span").css({"position":"absolute"});
				  } else {
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