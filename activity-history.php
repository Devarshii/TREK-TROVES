<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login']) == 0) {	
	header('location:index.php');
} else {
	$usersql = "SELECT id FROM tblusers WHERE EmailId=:email";
	$userquery = $dbh->prepare($usersql);
	$userquery->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
	$userquery->execute();
	$userresults = $userquery->fetch(PDO::FETCH_OBJ);
	$userId = ($userquery->rowCount() > 0) ? intval($userresults->id) : 0;
	?>
	<!DOCTYPE HTML>
	<html>
		<head>
			<title>Trek Troves</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="keywords" content="Tourism Management System In PHP" />
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
			<script>
				new WOW().init();
			</script>
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
				th {
					text-align: center;
				}
			</style>
		</head>
		<body>
			<!-- top-header -->
			<div class="top-header">
			<?php include('includes/header.php');?>
			<div class="banner-1 ">
				<div class="container">
					<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Trek Troves</h1>
				</div>
			</div>
			<!--- /banner-1 ---->
			<!--- privacy ---->
			<div class="privacy">
				<div class="container">
					<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">My Activity History</h3>
					<form name="chngpwd" method="post" onSubmit="return valid();">
						<?php if($_SESSION['error']) { ?>
							<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']) ?> </div>
						<?php } else if($_SESSION['msg']) { ?>
							<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']) ?> </div>
						<?php } ?>
						<p>
						<table border="1" width="100%">
							<tr align="center">
								<th>#</th>
								<th>Image</th>
								<th>Activity Name</th>
								<th>From</th>
								<th>To</th>
								<th>Price</th>
								<th>Order Date</th>
							</tr>
							<?php 
								$sql = "SELECT 
									a.id AS eid,
									a.activityImage,
									a.title AS activityName,
									o.id AS oid,
									o.startingDate,
									o.endingDate,
									o.totalPrice,
									o.createdOn
								FROM 
									tblactivityorder o
								JOIN 
									tbladventureactivities a
										ON a.id = o.activityId
								WHERE
									o.userId = :userId AND
									o.orderStatus = 1
								ORDER BY
									o.createdOn";
								$query = $dbh->prepare($sql);
								$query->bindParam(':userId', $userId);
								$query->execute();
								$results = $query->fetchAll(PDO::FETCH_OBJ);
								$cnt = 1;
								if($query->rowCount() > 0) {
									foreach($results as $result) { ?>
										<tr align="center">
											<td><?php echo htmlentities($result->eid);?></td>
											<td style="padding: 5px">
												<?php if(file_exists('admin/activityImage/' . $result->activityImage)) { ?>
													<img src="admin/activityImage/<?php echo $result->activityImage;?>" class="img-responsive" alt="" height="100" width="100">
												<?php } ?>
											</td>
											<td><?php echo htmlentities($result->activityName);?></td>
											<td><?php echo $result->startingDate;?></td>
											<td><?php echo $result->endingDate;?></td>
											<td><?php echo htmlentities($result->totalPrice);?></td>
											<td><?php echo $result->createdOn; ?></td>
										</tr>
										<?php $cnt=$cnt+1; 
									}
								} ?>
						</table>
						</p>
					</form>
				</div>
			</div>
			<!--- /privacy ---->
			<!--- footer-top ---->
			<!--- /footer-top ---->
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
<?php } ?>