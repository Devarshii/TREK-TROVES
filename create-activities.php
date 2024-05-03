<?php
   session_start();
   error_reporting(0);
   include('includes/config.php');
   if(strlen($_SESSION['alogin'])==0) {
   	header('location:index.php');
   } else{
   	if(isset($_POST['submit'])) {
   		$title=$_POST['title'];
   		$description=$_POST['description'];
         $price_per_day = $_POST['price_per_day'];
   		$aimage = time() . $_FILES["activityImage"]["name"];
   		move_uploaded_file($_FILES["activityImage"]["tmp_name"], "activityImage/" . $aimage);
   		$sql="INSERT INTO tbladventureactivities(title, description, price_per_day, activityImage, status) VALUES(:title,:description, :price_per_day, :aimage, 1)";
   		$query = $dbh->prepare($sql);
   		$query->bindParam(':title', $title);
   		$query->bindParam(':description', $description);
         $query->bindParam(':price_per_day', $price_per_day);
   		$query->bindParam(':aimage', $aimage);
   		$query->execute();
   		$lastInsertId = $dbh->lastInsertId();
   		if($lastInsertId) {
   			$msg="Activity Created Successfully";
   		} else  {
   			$error="Something went wrong. Please try again";
   		}
   	} ?>
<!DOCTYPE HTML>
<html>
   <head>
      <title>Trek Troves | Admin Activity Creation</title>
      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
      <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
      <link href="css/style.css" rel='stylesheet' type='text/css' />
      <link rel="stylesheet" href="css/morris.css" type="text/css"/>
      <link href="css/font-awesome.css" rel="stylesheet">
      <script src="js/jquery-2.1.4.min.js"></script>
      <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
      <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
      <div class="page-container">
         <!--/content-inner-->
         <div class="left-content">
            <div class="mother-grid-inner">
               <!--header start here-->
               <?php include('includes/header.php');?>
               <div class="clearfix"> </div>
            </div>
            <!--heder end here-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Activity </li>
            </ol>
            <!--grid-->
            <div class="grid-form">
               <!---->
               <div class="grid-form1">
                  <h3>Create Adventure Activity</h3>
                  <?php if($error){ ?>
                  <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                  <?php } else if($msg){ ?>
                  <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                  <?php } ?>
                  <div class="tab-content">
                   	<div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" name="title" method="post" enctype="multipart/form-data">
                         <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-8">
                               <input type="text" class="form-control1" name="title" id="title" placeholder="Create Activity" required>
                            </div>
                         </div>
                         <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Price Per Day</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control1" name="price_per_day" id="price_per_day" placeholder="Price Per Day" required>
                           </div>
                        </div>
                         <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-8">
                               <textarea class="form-control" rows="5" cols="50" name="description" id="description" placeholder="Description" required></textarea> 
                            </div>
                         </div>
                         <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label">Activity Image</label>
                            <div class="col-sm-8">
                               <input type="file" name="activityImage" id="activityImage" required>
                            </div>
                         </div>
                         <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                               <button type="submit" name="submit" class="btn-primary btn">Create</button>
                               <button type="reset" class="btn-inverse btn">Reset</button>
                            </div>
                         </div>
                   		</form>
                   	</div>
                   	<div class="panel-footer">
                   	</div>
                  </div>
               </div>
               <!--//grid-->
               <!-- script-for sticky-nav -->
               <script>
                  $(document).ready(function() {
                  	 var navoffeset=$(".header-main").offset().top;
                  	 $(window).scroll(function(){
                  		var scrollpos=$(window).scrollTop(); 
                  		if(scrollpos >=navoffeset){
                  			$(".header-main").addClass("fixed");
                  		}else{
                  			$(".header-main").removeClass("fixed");
                  		}
                  	 });
                  	 
                  });
               </script>
               <!-- /script-for sticky-nav -->
               <!--inner block start here-->
               <div class="inner-block">
               </div>
               <!--inner block end here-->
               <!--copy rights start here-->
               <?php include('includes/footer.php');?>
               <!--COPY rights end here-->
            </div>
         </div>
         <!--//content-inner-->
         <!--/sidebar-menu-->
         <?php include('includes/sidebarmenu.php');?>
         <div class="clearfix"></div>
      </div>
      <script>
         var toggle = true;
         			
         $(".sidebar-icon").click(function() {                
           if (toggle)
           {
         	$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
         	$("#menu span").css({"position":"absolute"});
           }
           else
           {
         	$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
         	setTimeout(function() {
         	  $("#menu span").css({"position":"relative"});
         	}, 400);
           }
         				
         				toggle = !toggle;
         			});
      </script>
      <!--js -->
      <script src="js/jquery.nicescroll.js"></script>
      <script src="js/scripts.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
      <!-- /Bootstrap Core JavaScript -->	   
   </body>
</html>
<?php } ?>