<?php
include('../includes/config.php');

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

// Merchant key here as provided by Razorpay
$KEY = "rzp_test_xsiOz9lYtWKHgF"; // $KEY = "rzp_live_DVUdRdkTqQLL2X";

$action = '';
$posted = array();
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $posted[$key] = $value;
    }
}
?>

<html>

<body>
    <?php
    if($param_array['module'] == "equipment") {
        $page = "place_order";
        $ordersql = "SELECT 
                  u.FullName AS full_name,
                  u.EmailId,
                  u.MobileNumber AS contact_number,
                  o.totalPrice
                FROM 
                  tblequipmentorder o
                JOIN 
                  tblusers u
                  ON u.id = o.userId
                WHERE
                  o.id = :oid";
    } else if($param_array['module'] == "activity") {
        $page = "activity_place_order";
        $ordersql = "SELECT 
                      u.FullName AS full_name,
                      u.EmailId,
                      u.MobileNumber AS contact_number,
                      o.totalPrice
                    FROM 
                      tblactivityorder o
                    JOIN 
                      tblusers u
                      ON u.id = o.userId
                    WHERE
                      o.id = :oid";
    } else if($param_array['module'] == "package") {
        $page = "package_place_order";
        $ordersql = "SELECT 
                      u.FullName AS full_name,
                      u.EmailId,
                      u.MobileNumber AS contact_number,
                      o.PackagePrice AS totalPrice
                    FROM 
                      tblbooking o
                    JOIN 
                      tblusers u
                      ON u.id = o.userId
                    WHERE
                      o.BookingId = :oid";
    }
    $orderquery = $dbh->prepare($ordersql);
    $orderquery->bindParam(':oid', $param_array['order_id']);
    $orderquery->execute();

    if ((int)$orderquery->rowCount() <= 0) {
      $_SESSION['error'] = "Error.";
    } else { 
        $results = $orderquery->fetch(PDO::FETCH_OBJ); ?>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

        <!-- -------------------------------- Razor Pay -->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <script>

            $(document).ready(function(e) {
                var totalAmount = '<?= (int)$results->totalPrice; ?>';
                var options = {
                    "key": '<?= $KEY ?>',
                    "amount": (totalAmount * 100), // 2000 paise = INR 20
                    "name": "Trektroves", // Sagar Khatri
                    "description": "Payment",
                    "image": "",
                    "handler": function(response) {
                        // console.log('Response', response);
                        var paymentStatus = 1;
                        razorpayPaymentId = "-";

                        if (typeof response.razorpay_payment_id == 'undefined' || response.razorpay_payment_id < 1) {
                            paymentStatus = 2;
                        } else {
                            razorpayPaymentId = response.razorpay_payment_id;
                        }

                        if (paymentStatus == 1) {
                            params = btoa("type=1&txnid=" + razorpayPaymentId + "&oid=" + <?php echo $param_array['order_id']; ?>);
                        } else {
                            params = btoa("type=2&txnid=" + razorpayPaymentId + "&oid=" + <?php echo $param_array['order_id']; ?>);
                        }

                        <?php $pageLink = "../" . $page . ".php?get_param="; ?>

                        location.href = '<?= $pageLink ?>' + params;
                    },
                    "theme": {
                        "color": "#528FF0"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
                e.preventDefault();
            });
        </script>
    <?php } ?>
</body>

</html>