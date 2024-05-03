<?php

include('../config.php');
$status=$_POST["status"];

$firstname=$_POST["firstname"];

$amount=$_POST["amount"];

$txnid=$_POST["txnid"];



$posted_hash=$_POST["hash"];

$key=$_POST["key"];

$productinfo=$_POST["productinfo"];

$email=$_POST["email"];

$udf1=$_POST["udf1"];


If (isset($_POST["additionalCharges"])) {

       $additionalCharges=$_POST["additionalCharges"];

        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

        

                  }

	else {	  



        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;



         }

		 $hash = hash("sha512", $retHashSeq);

  

       if ($hash != $posted_hash) {

	       echo "Invalid Transaction. Please try again";

		   }

	   else {
 fireQuery("UPDATE order_detail SET order_status = 2 WHERE id = " . $udf1);

         echo "<h4>Your transaction id for this transaction is ".$txnid.". You may try making the payment by clicking the link below.</h4>";

          

		 } 

?>

<!--Please enter your website homepagge URL -->

<p><a href=index.php> Try Again</a></p>