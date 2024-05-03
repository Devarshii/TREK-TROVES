<?php
require('../config.php');

$get_param = base64_decode($_GET['get_param']);
$get_param_array = explode("&", $get_param);
$param_array = array();
$all_key = $all_val = array();
foreach($get_param_array as $key => $value) {
    $get_array = explode("=", $value);
    $all_key[] = $get_array[0];
    $all_val[] = $get_array[1];
}
$param_array = array_combine($all_key, $all_val);

// Merchant key here as provided by Payu
$MERCHANT_KEY = "5qKzs5qx";
//$MERCHANT_KEY = "Y7baHH";

// Merchant Salt as provided by Payu
$SALT = "MRmUBaZZHm";
//$SALT = "8bojiCPBnhRPJ9afLiGEOKrJI6OdoRbo";
// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://secure.payu.in";

$action = '';
$posted = array();
if(!empty($_POST)) {
  //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}

$hash = '';

// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

//$action = $PAYU_BASE_URL . '/_payment';
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['surl'])
          || empty($posted['furl'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
    $hashVarsSeq = explode('|', $hashSequence);

    $hash_string = '';  

    foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

<html>
  <head>
    <script>
      var hash = '<?php echo $hash ?>';
      function submitPayuForm() {
        if(hash == '') {
          return;
        }
        var payuForm = document.forms.payuForm;
        payuForm.submit();
      }
    </script>
  </head>

  <body onload="submitPayuForm()">
    <?php  
    $projectDetailsQuery = select_query('project_courses', '*', 'project_courses_id = "' . $param_array['course_id'] . '"');
    $studentDetailsQuery = select_query('course_booking_master', '*', 'booking_id = "' . $param_array['s_id'] . '"');

    if (mysqli_num_rows($projectDetailsQuery) <= 0   || mysqli_num_rows($studentDetailsQuery) <= 0 ) {
      $_SESSION['reg_message'] = "Error.";
        //jsRedirect('../../index.php');
    } else {
      $projectDetails = mysqli_fetch_object($projectDetailsQuery);
      $studentDetails = mysqli_fetch_object($studentDetailsQuery); 
      ?>
      <form action="<?php echo $action; ?>" method="post" name="payuForm">

        <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />

        <input type="hidden" name="hash" value="<?php echo $hash ?>"/>

        <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
        <!--<?php echo $projectDetails->registration_fees  ?>  -->
        <input type="hidden" name="amount" value="<?php echo $projectDetails->registration_fees  ?>" />
        <input type="hidden" name="firstname" id="firstname" value="<?php echo  $studentDetails->full_name ?>" />
          <input type="hidden" name="email" id="email" value="khatrisagar2@gmail.com" />  
        <input type="hidden" name="phone" id="phone" value="<?php echo  $studentDetails->contact_number ?>" />
        <input type="hidden" name="surl" id="surl" value="<?php echo getCallbackUrl(1,$param_array) ?>" />
        <input type="hidden" name="furl" id="furl" value="<?php echo getCallbackUrl(2,$param_array) ?>" />
        <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
        <input type="hidden" name="udf1" value="<?php echo $param_array['order_code']?>"   />
        <input type="hidden" name="curl" value="" />
         <input type="hidden" name="productinfo" value="productinfo" />
          
         
        
        <?php if(!$hash) { ?>
          <input id="btnSubmit" type="submit" value="Submit" style="display:none"  />  
        <?php } ?>
    </form>
  <?php } ?>

  <?php
  function getCallbackUrl($type,$param_array) {
    if($type == 1){
    $params = base64_encode("type=1&oid=" . $param_array['order_code'] . "&s_id=" . $param_array['s_id']);
      $pageLink = "course_registration_success.php?get_param=" . $params;
    }else{
        $params = base64_encode("type=2");
      $pageLink = "course_registration_success.php?get_param=" . $params;
    }
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "https://";
    $uri = str_replace('/index.php','/',$_SERVER['REQUEST_URI']);
    return $protocol . $_SERVER['HTTP_HOST'] . '/' . $pageLink;
  } ?>

  </body>
</html>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script> 
$(document).ready(function() {
  document.getElementById("btnSubmit").click();
});
</script>