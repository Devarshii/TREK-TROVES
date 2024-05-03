<?php
  session_start();
  error_reporting(0);
  include('includes/config.php');
  ?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Trek Troves  | Activity List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script>
      new WOW().init();
    </script>
    <script src="js/jquery-ui.js"></script>
    <script>
      $(function() {
        var lastValidEndDates = {};

        $(".startDate").datepicker({
              dateFormat: 'yy-mm-dd',
              minDate: 0,
              onSelect: function(selectedDate) {
                  var index = $(".startDate").index(this);
                  var minDate = $(this).datepicker('getDate');
                  $(".endDate").eq(index).datepicker('option', 'minDate', minDate || 0);
                  checkEndDate(index, $(this).attr('data-id'));
              }
          });

          $(".endDate").datepicker({
              dateFormat: 'yy-mm-dd',
              minDate: 0,
              onSelect: function(selectedDate) {
                  var index = $(".endDate").index(this);
                  lastValidEndDates[index] = $(this).datepicker('getDate');
                  checkEndDate(index, $(this).attr('data-id'));
              }
          });

          function checkEndDate(index, dataId) {
              var startDate = $(".startDate").eq(index).datepicker('getDate');
              var endDate = $(".endDate").eq(index).datepicker('getDate');

              if (startDate && endDate && endDate < startDate) {
                  if (lastValidEndDates[index]) {
                      $(".endDate").eq(index).datepicker('setDate', lastValidEndDates[index]);
                  } else {
                      $(".endDate").eq(index).val('');
                  }
              } else {
                  lastValidEndDates[index] = endDate;
              }

              calculate(dataId);
          }
      });
    </script>
    <!--//end-animate-->
  </head>
  <body>
    <?php include('includes/header.php');?>
    <!--- banner ---->
    <div class="banner-3">
      <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> Trek Troves - Activity List</h1>
      </div>
    </div>
    <!--- /banner ---->
    <!--- rooms ---->
    <div class="rooms">
      <div class="container">
        <div class="room-bottom">
          <!-- <h3>Activity List : </h3> -->
          <?php $sql = "SELECT * from tbladventureactivities WHERE status = 1";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query->rowCount() > 0) {
              foreach($results as $result) {	?>
                <form name="equipmentorder" action="activity_place_order.php" method="post">
                  <div class="selectroom_top">
                    <div class="col-md-4 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                      <img src="admin/activityImage/<?php echo htmlentities($result->activityImage);?>" class="img-responsive" alt="No image">
                    </div>
                    <div class="col-md-8 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                      <h3> <?php echo htmlentities($result->title);?></h3>
                      <p><?php echo htmlentities($result->description);?></p>
                      <p><b>Price Per Day:</b> <?php echo htmlentities($result->price_per_day);?></p>
                      <div class="ban-bottom">
                        <div class="bnr-right">
                          <label class="inputLabel">From</label>
                          <input class="date startDate startingDate<?php echo $result->id ?>" data-id="<?php echo $result->id ?>" type="text" placeholder="dd-mm-yyyy" value="<?php echo date("Y-m-d"); ?>" name="startingDate" required="">
                        </div>
                        <div class="bnr-right">
                          <label class="inputLabel">To</label>
                          <input class="date endDate endingDate<?php echo $result->id ?>" data-id="<?php echo $result->id ?>" type="text" placeholder="dd-mm-yyyy" value="<?php echo date("Y-m-d"); ?>" name="endingDate" required="">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="grand">
                        <p>Grand Total</p>
                        <input type="hidden" class="price_per_day_<?php echo $result->id; ?>" value="<?php echo $result->price_per_day ?>">
                        <input type="hidden" name="activityId" value="<?php echo $result->id ?>">
                        <h3 class="price totalPrice<?php echo $result->id; ?>">INR. <?php echo number_format($result->price_per_day, 2);?></h3>
                      </div>
                    </div>
                    <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; float: right; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp;">
                      <ul>
                        <?php if($_SESSION['login']) { ?>
                          <li class="spe" align="center">
                            <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                          </li>
                        <?php } else { ?>
                          <li class="sigi" align="center" style="margin-top: 1%">
                            <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn" > Book</a>
                          </li>
                        <?php } ?>
                        <div class="clearfix"></div>
                      </ul>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </form>
              <?php }
            } ?>
        </div>
      </div>
    </div>
    <!--- /rooms ---->
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
    <!-- //write us -->
    <script type="text/javascript">
      function calculate(thisId) {
          var startingDate = new Date($('.startingDate' + thisId).val());
          var endingDate = new Date($('.endingDate' + thisId).val());
          var price_per_day = parseFloat($('.price_per_day_' + thisId).val());

          // Calculate difference in days
          var timeDiff = endingDate.getTime() - startingDate.getTime();
          var dayDiff = (timeDiff / (1000 * 3600 * 24)) + 1;

          // Calculate total price
          var totalPrice = dayDiff * price_per_day;
          $('.totalPrice' + thisId).text("INR. " + totalPrice.toFixed(2));
      }

      $(document).on('change', '.date', function() {
        calculate($(this).attr('data-id'));
      });
    </script>
  </body>
</html>