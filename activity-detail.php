<?php
  session_start();
  error_reporting(0);
  include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Trek Troves</title>
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
      $( "#datepicker,#datepicker1" ).datepicker();
      });
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
    </style>
  </head>
  <body>
    <!-- top-header -->
    <?php include('includes/header.php');?>
    <div class="banner-3">
      <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> Trek Troves - Activity Details</h1>
      </div>
    </div>
    <!--- /banner ---->
    <!--- selectroom ---->
    <div class="selectroom">
      <div class="container">
        <?php if($error){?>
        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
        <?php } 
          else if($msg){?>
        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
        <?php } ?>
        <?php 
          $aid=intval($_GET['aid']);
          $sql = "SELECT * from tbladventureactivities where id=:aid";
          $query = $dbh->prepare($sql);
          $query -> bindParam(':aid', $aid, PDO::PARAM_STR);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query->rowCount() > 0)
          {
            foreach($results as $result)
            {	?>
              <div class="selectroom_top">
                <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                  <img src="admin/activityImage/<?php echo htmlentities($result->activityImage);?>" class="img-responsive" alt="">
                </div>
                <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                  <h2><?php echo htmlentities($result->title);?></h2>
                </div>
                <h3>Activity Details</h3>
                <p style="padding-top: 1%"><?php echo htmlentities($result->description);?> </p>
                <div class="clearfix"></div>
              </div>
            <?php }
          } ?>
      </div>
    </div>
    <!--- /selectroom ---->
    <<!--- /footer-top ---->
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