<?php
session_start();
// error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit2']))
{
	$usersql = "SELECT id FROM tblusers WHERE EmailId=:email";
	$userquery = $dbh->prepare($usersql);
	$userquery->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
	$userquery->execute();
	$userresults = $userquery->fetch(PDO::FETCH_OBJ);

	$packagesql = "SELECT packageId as id, PackagePrice FROM tbltourpackages WHERE PackageId = :pid";
	$packagequery = $dbh->prepare($packagesql);
	$packageId = intval($_POST['packageId']);
	$packagequery->bindParam(':pid', $packageId);
	$packagequery->execute();
	$packageresults = $packagequery->fetch(PDO::FETCH_OBJ);

	$pid = intval($packageresults->id);
	$userId 		= ($userquery->rowCount() > 0) ? intval($userresults->id) : 0;
	$PackagePrice = $packageresults->PackagePrice;
	$useremail = $_SESSION['login'];
	$fromdate = $todate = "";
	if(!empty($_POST['tourTimings'])) {
		$tourTimings = explode("_", $_POST['tourTimings']);
		$fromdate = $tourTimings[0];
		$todate = $tourTimings[1];
	}

	$comment = $_POST['comment'];
	$status = 0;

	$sql = "INSERT INTO tblbooking(PackageId, userId, UserEmail, FromDate, ToDate, Comment, PackagePrice, status) VALUES(:pid, :userId, :useremail, :fromdate, :todate, :comment, :PackagePrice, :status)";
	$query = $dbh->prepare($sql);

	$query->bindParam(':pid', $pid);
	$query->bindParam(':userId', $userId);
	$query->bindParam(':useremail', $useremail);
	$query->bindParam(':fromdate', $fromdate);
	$query->bindParam(':todate', $todate);
	$query->bindParam(':comment', $comment);
	$query->bindParam(':status', $status);
	$query->bindParam(':PackagePrice', $PackagePrice);
	$query->execute();

	$lastInsertId = $dbh->lastInsertId();

	/*Payment Start */
	$params = base64_encode("order_id=" . $lastInsertId . "&module=package");
	header("location:razorpay/razorpay.php?get_param=" . $params);
} else {
	$get_param = base64_decode($_GET['get_param']);
	$get_param_array = explode("&", $get_param);
	$param_array = array();
	$all_key = $all_val = array();
	foreach ($get_param_array as $key => $value) {
		$get_array = explode("=", $value);
		$all_key[] = $get_array[0];
		$all_val[] = $get_array[1];
	}
	$param_array = array_combine($all_key, $all_val);

	if (isset($param_array['type']) && $param_array['type'] == 1) {
		$txnid = isset($param_array["txnid"]) ? $param_array["txnid"] : "";

		$sql = "UPDATE tblbooking SET status = 1, paymentResponse = :paymentResponse, UpdationDate = :updatedOn WHERE BookingId = :oid";
		$date = date("Y-m-d H:i:s");
		$query = $dbh->prepare($sql);
		$query->bindParam(':paymentResponse', $txnid);
		$query->bindParam(':oid', $param_array['oid']);
		$query->bindParam(':updatedOn', $date);

		if($query->execute()) {
			$_SESSION['msg'] = "Booked Successfully";
		} else {
			$_SESSION['error'] = "Something went wrong. Please try again";
		}
	} else {
		$_SESSION['error'] = "Something went wrong. Please try again";
	}
	header('location:tour-history.php');
}
?>