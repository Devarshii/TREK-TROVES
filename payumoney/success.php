<?php

include('../config.php');
$response = $_POST;
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$udf1=$_POST["udf1"];

$salt="MRmUBaZZHm";

if (isset($_POST["additionalCharges"])) {
  $additionalCharges=$_POST["additionalCharges"];
  $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
} else {
  $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}

$hash = hash("sha512", $retHashSeq);
/*if ($hash != $posted_hash) {

  echo "Invalid Transaction. Please try again";

} else { */
  fireQuery("UPDATE order_detail SET order_status = 1,payment_checkout_response = '" . serialize($response) . "',txn_id = '" . $txnid . "' WHERE id = " . $udf1);

  echo "<h3>Thank you for the registration. Kindly download your joining letter from the mail id that you provided. We will inform you about the starting date and time of your batch. For any further queries kindly contact on +91 97259 80975.</h3>";

  /*  echo "<h4>Your Transaction ID for this transaction is "$txnid".</h4>";
  echo "<h4>We have received a payment of Rs. " . $amount . ".</h4>";*/
  /*  }  */
?>