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

	$activitysql = "SELECT id, price_per_day FROM tbladventureactivities WHERE id = :aid";
	$activityquery = $dbh->prepare($activitysql);
	$activityId = intval($_POST['activityId']);
	$activityquery->bindParam(':aid', $activityId);
	$activityquery->execute();
	$activityresults = $activityquery->fetch(PDO::FETCH_OBJ);

	$userId 		= ($userquery->rowCount() > 0) ? intval($userresults->id) : 0;
	$activityId		= intval($_POST['activityId']);
	$startingDate	= $_POST['startingDate'];
	$endingDate		= $_POST['endingDate'];
	$price_per_day	= $_POST['price_per_day'];
	$qty			= 1;

	$diff 			= strtotime($endingDate) - strtotime($startingDate); 
    $totalDays 		= (int)abs(round($diff / 86400)) + 1;

	$originalPrice 	= ($activityquery->rowCount() > 0) ? $activityresults->price_per_day : 0;
	$totalPrice 	= $totalDays * $originalPrice * $qty;

	$orderStatus	= 0;

	$sql = "INSERT INTO tblactivityorder (activityId, userId, originalPrice, startingDate, endingDate, totalDays, totalPrice, orderStatus) VALUES(:activityId, :userId, :originalPrice, :startingDate, :endingDate, :totalDays, :totalPrice, :orderStatus)";
	$query = $dbh->prepare($sql);

	$query->bindParam(':activityId', $activityId);
	$query->bindParam(':userId', $userId);
	$query->bindParam(':originalPrice', $originalPrice);
	$query->bindParam(':startingDate', $startingDate);
	$query->bindParam(':endingDate', $endingDate);
	$query->bindParam(':totalDays', $totalDays);
	$query->bindParam(':totalPrice', $totalPrice);
	$query->bindParam(':orderStatus', $orderStatus);
	$query->execute();

	$lastInsertId = $dbh->lastInsertId();

	/*Payment Start */
	$params = base64_encode("order_id=" . $lastInsertId . "&module=activity");
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

		$sql = "UPDATE tblactivityorder SET orderStatus = 1, paymentResponse = :paymentResponse, updatedOn = :updatedOn WHERE id = :oid";
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
	header('location:myorders.php');
}
?>