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

	$equipmentsql = "SELECT id, price_per_day FROM tblequipments WHERE id = :eid";
	$equipmentquery = $dbh->prepare($equipmentsql);
	$equipmentId = intval($_POST['equipmentId']);
	$equipmentquery->bindParam(':eid', $equipmentId);
	$equipmentquery->execute();
	$equipmentresults = $equipmentquery->fetch(PDO::FETCH_OBJ);

	$userId 		= ($userquery->rowCount() > 0) ? intval($userresults->id) : 0;
	$equipmentId	= intval($_POST['equipmentId']);
	$startingDate	= $_POST['startingDate'];
	$endingDate		= $_POST['endingDate'];
	$qty			= $_POST['qty'];

	$diff 			= strtotime($endingDate) - strtotime($startingDate); 
    $totalDays 		= (int)abs(round($diff / 86400)) + 1;

	$originalPrice 	= ($equipmentquery->rowCount() > 0) ? $equipmentresults->price_per_day : 0;
	$totalPrice 	= $totalDays * $originalPrice * $qty;

	$orderStatus	= 0;

	$sql = "INSERT INTO tblequipmentorder (equipmentId, userId, originalPrice, startingDate, endingDate, totalDays, qty, totalPrice, orderStatus) VALUES(:equipmentId, :userId, :originalPrice, :startingDate, :endingDate, :totalDays, :qty, :totalPrice, :orderStatus)";
	$query = $dbh->prepare($sql);

	$query->bindParam(':equipmentId', $equipmentId);
	$query->bindParam(':userId', $userId);
	$query->bindParam(':originalPrice', $originalPrice);
	$query->bindParam(':startingDate', $startingDate);
	$query->bindParam(':endingDate', $endingDate);
	$query->bindParam(':totalDays', $totalDays);
	$query->bindParam(':qty', $qty);
	$query->bindParam(':totalPrice', $totalPrice);
	$query->bindParam(':orderStatus', $orderStatus);
	$query->execute();

	$lastInsertId = $dbh->lastInsertId();

	/*Payment Start */
	$params = base64_encode("order_id=" . $lastInsertId . "&module=equipment");
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
		$sql = "UPDATE tblequipmentorder SET orderStatus = 1, paymentResponse = :paymentResponse, updatedOn = :updatedOn WHERE id = :oid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':paymentResponse', json_encode($response));
		$query->bindParam(':oid', $param_array['oid']);
		$query->bindParam(':updatedOn', date("Y-m-d H:i:s"));
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