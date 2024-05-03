<?php
session_start();
error_reporting(0);
include "includes/config.php";
if (strlen($_SESSION["alogin"]) == 0) {
    header("location:index.php");
} else {

  $pid = intval($_GET["pid"]);
  if (!empty($_GET["type"]) && $_GET["type"] =='delete') {
  	$imageId 	= !empty($_GET["imageId"]) ? $_GET["imageId"] : 0;
		$sql = "SELECT id, packageImage from tbltourpackageimages WHERE id = :imageId";
		$query = $dbh->prepare($sql);
		$query->bindParam(":imageId", $imageId);
		$query->execute();
		$resultsimage = $query->fetch(PDO::FETCH_OBJ);
  	if(file_exists('packageImages/' . $resultsimage->packageImage)) {
  		unlink('packageImages/' . $resultsimage->packageImage);
  	}

    $sql = "DELETE FROM tbltourpackageimages WHERE id = :imageId";
    $query = $dbh->prepare($sql);
		$query->bindParam(":imageId", $imageId);
    $query->execute();
		header('location:change-image.php?pid=' . $pid);
  } else if (isset($_POST["submit"])) {
  	$pid 			= !empty($_POST["pid"]) ? $_POST["pid"] : 0;
  	$imageId 	= !empty($_POST["imageId"]) ? $_POST["imageId"] : 0;

  	if(!empty($_FILES["packageImage"]["name"])) {
	    $pimage = time() . $_FILES["packageImage"]["name"];
	    move_uploaded_file(
	      $_FILES["packageImage"]["tmp_name"],
	      "packageImages/" . $pimage
	    );

	  	if(!empty($imageId)) {
		    if(!empty($pimage)) {
		    	if(file_exists('packageImages/' . $_POST['oldpackageimage'])) {
		    		unlink('packageImages/' . $_POST['oldpackageimage']);
		    	}
			    $sql = "UPDATE tbltourpackageimages SET packageImage = :pimage WHERE id = :imageId";
			    $query = $dbh->prepare($sql);

			    $query->bindParam(":imageId", $imageId);
			    $query->bindParam(":pimage", $pimage);
			    $query->execute();
			  }
		  } else if (isset($pid)) {
		    $image = time() . $_FILES["packageImage"]["name"];
		    move_uploaded_file($_FILES["packageImage"]["tmp_name"],"packageImages/" . $image);
				$sql="INSERT INTO tbltourpackageimages (packageId, packageImage, status) VALUES (:pid, :pimage, 1)";
				$query = $dbh->prepare($sql);
				$query->bindParam(':pid', $pid);
				$query->bindParam(':pimage', $pimage);
				$query->execute();
			}

    	$_SESSION['msg'] = "Success";
		}

		header('location:change-image.php?pid=' . $pid);
  } ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Trek Troves | Admin Package Creation</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
			Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include "includes/header.php"; ?>
					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Package Image </li>
				</ol>
				<!--grid-->
				<div class="grid-form">
					<!---->
					<div class="grid-form1">
						<h3>Manage Package Image </h3>
						<?php if ($_SESSION['error']) { ?>
							<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?> </div>
						<?php } elseif ($_SESSION['msg']) { ?>
							<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']) ?> </div>
						<?php } ?>
						<div class="tab-content">
							<div class="tab-pane active" id="horizontal-form">
								<div class="row">
									<div class="col-md-12">
										<?php
										$sql = "SELECT id, packageImage from tbltourpackageimages where packageId = :pid";
										$query = $dbh->prepare($sql);
										$query->bindParam(":pid", $pid);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) { ?>
												<div class="col-md-3">
													<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
														<div class="form-group">
															<img height="200" src="packageImages/<?php echo htmlentities($result->packageImage); ?>" width="200">
														</div>
														<div class="form-group">
															<input type="file" name="packageImage" id="packageImage" required>
															<br>
															<input type="hidden" name="pid" value="<?php echo $pid; ?>">
															<input type="hidden" name="oldpackageimage" value="<?php echo $result->packageImage; ?>">
															<input type="hidden" name="imageId" value="<?php echo $result->id; ?>">
															<button type="submit" name="submit" class="btn-primary btn">Update</button>
															<a href="change-image.php?type=delete&pid=<?php echo $pid; ?>&imageId=<?php echo $result->id; ?>" class="btn-danger btn">Remove</a>
														</div>
													</form>
												</div>
											<?php }
										} ?>
										<div class="col-md-3">
											<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
												<div class="form-group">
												</div>
												<div class="form-group">
													<input type="file" name="packageImage" id="packageImage" required>
													<br>
													<input type="hidden" name="pid" value="<?php echo $pid; ?>">
													<button type="submit" name="submit" class="btn-primary btn">Update</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
							</div>
						</div>
					</div>
					<!--//grid-->
					<!-- script-for sticky-nav -->
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
					<!-- /script-for sticky-nav -->
					<!--inner block start here-->
					<div class="inner-block">
					</div>
					<!--inner block end here-->
					<!--copy rights start here-->
					<?php include "includes/footer.php"; ?>
					<!--COPY rights end here-->
				</div>
			</div>
			<!--//content-inner-->
			<!--/sidebar-menu-->
			<?php include "includes/sidebarmenu.php"; ?>
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
<?php
	} ?>