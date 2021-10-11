<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_POST['btn_password'])){
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $password = mysqli_real_escape_string($conn, $password);
        $password2 = mysqli_real_escape_string($conn, $password2);

        if(empty($password) || empty($password2)){
            $_SESSION['ErrorMessage'] = "All Fields are Required";
        }elseif($password != $password2){
            $_SESSION['ErrorMessage'] = "Both Password Do Not Match";
        }else{
            $newpassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE tbluser SET password='$newpassword' WHERE email = '{$_SESSION['email']}' ";
            $query_result = mysqli_query($conn, $sql);
            if($query_result){
              $_SESSION['SuccessMessage'] = "User password has been change successfully";
              RedirectTo('index.php');
            }else{
              $_SESSION['ErrorMessage'] = "Failed to change your password";
            }
        }
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <?php include_once('includes/styles.html'); ?>
    <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
           	              <h4 class="panel-heading">Change Password</h4>
                      </div> 
                      <form action="change_password.php" method="POST">
                        <div class="panel-body">
                          <div class="col-sm-12">
                                        <div class="form-body">
                                            <span id="sprytextfield1">
                                              <label for="password">New Password</label>
                                              <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <span id="sprytextfield2">
                                              <label for="password2">Confirm New Password</label>
                                              <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm New Password...">
                                              <span class="textfieldRequiredMsg">Please enter a valid password.</span>
                                            </span> 
                                        </div>
                                    </div>                                       
                          <div class="form-body">
                            <button type="submit" class="form-control btn btn-sm btn-primary" name="btn_password">Submit</button>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
</script>
</body>

</html>
