<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_POST['btn_submit'])){
        $email = $_POST['email'];

        $email = mysqli_real_escape_string($conn, $email);

        if(empty($email)){
            $_SESSION['ErrorMessage'] = "Enter your email address";
        }else{
            $sql = "SELECT * FROM tblstudent WHERE email = '$email'";
            $query_result = mysqli_query($conn, $sql);
            $result = mysqli_num_rows($query_result);
            if($result > 0){
                while($row = mysqli_fetch_array($query_result)){
                  $_SESSION['email'] = $row['email'];
                }
                  RedirectTo('change_password.php');
            }else{
                $_SESSION['ErrorMessage'] = "Invalid Email Provided";
            }
        }
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <?php include_once('includes/styles.html'); ?>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
<section class="container-wrap">
    <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <?php
                      echo ErrorMessage();
                      echo SuccessMessage();
                  ?>
                  <div class="panel">
                      <div class="panel-header">
           	              <h4 class="panel-heading">Forget Password</h4>
                      </div> 
                      <form action="forget_password.php" method="POST">
                        <div class="panel-body">
                          <div class="form-body">
                         	  <span id="sprytextfield1">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                            <span class="textfieldRequiredMsg">Enter your email.</span></span> 
                          </div>                                        
                          <div class="form-body">
                            <button type="submit" class="form-control btn btn-sm btn-primary" name="btn_submit">Submit</button>
                          </div>
                        </div>
                      </form>
                  </div>

              </div>
          </div>
    </div>
</section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
</script>
</body>

</html>
