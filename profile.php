<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['matricno'])){

    }else{
        RedirectTo('index.php');
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afolabi's Profile</title>
    <?php include_once('includes/styles.html') ?>
</head>

<body>
    <?php include_once('includes/nav.php') ?>
    <section class="container-wrap">
        <div class="container wrap">
            <div class="row">
                <div class="col-md-4 col">
                    <?php include_once('includes/leftside.php') ?>
                </div>

                <div class="col-md-8 col">
                    <!-- Profile Information -->
                    <div class="gist-status">
                        <h4>Profile Information<small><a href="edit_profile.php"><span class="pull-right"><i class="fa fa-edit"></i> Edit Profile</span></a></small></h4>
                        <hr>
                        <h4><?php echo $_SESSION['surname'] ." ". $_SESSION['othername']; ?></h4>
                        <h5><?php echo $_SESSION['faculty']; ?></h5>
                        <h5><?php echo $_SESSION['department']; ?></h5>
                        <h5><?php echo $_SESSION['level']; ?></h5>
                        <h5><?php echo $_SESSION['program']; ?></h5>
                        <h5><?php echo $_SESSION['email']; ?></h5>
                    </div>
                </div>
            </div>    
        </div>
    </section>
    <?php include_once('includes/script.html') ?>
</body>
</html>