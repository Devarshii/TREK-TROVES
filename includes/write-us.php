<?php
error_reporting(0);
if(isset($_POST['submit']))
{
$issue=$_POST['issue'];
$description=$_POST['description'];
$email=$_SESSION['login'];
$sql="INSERT INTO  tblissues(UserEmail,Issue,Description) VALUES(:email,:issue,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':issue',$issue,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Your details have been successfully submitted.";
echo "<script type='text/javascript'> document.location = 'thankyou.php'; </script>";
}
else 
{
$_SESSION['msg']="Something went wrong. Please try again.";
echo "<script type='text/javascript'> document.location = 'thankyou.php'; </script>";
}
}
?>	
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                        
            </div>
            <section>
                <form name="help" method="post">
                    <div class="modal-body modal-spa">
                        <div class="writ" style="font-size: 16px; line-height: 1.6; font-weight: bold; padding: 20px;">
                            <h4>HOW CAN WE HELP YOU</h4>
                            <ul>
                                <li class="na-me">
                                    <select id="country" name="issue" class="frm-field required sect" required="" style="font-size: 16px;">
                                        <option value="">Select Issue</option>         
                                        <option value="Booking Issues">Booking Issues</option>
                                        <option value="Cancellation"> Cancellation</option>
                                        <option value="Refund">Refund</option>
                                        <option value="Other">Other</option>                                                        
                                    </select>
                                </li>
                                
                                <li class="descrip" style="margin-top: 10px;">
                                    <input class="special" type="text" placeholder="Description"  name="description" required="" style="font-size: 16px; padding: 8px;">
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="sub-bn">
                                <form>
                                    <button type="submit" name="submit" class="subbtn" style="font-size: 16px; padding: 10px 20px;">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
