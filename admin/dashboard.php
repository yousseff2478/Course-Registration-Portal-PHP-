<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    if(isset($_SESSION['username'])){

    }else{
        RedirectTo('index.php');
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username']; ?>'s Dashboard</title>
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
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?> 
                    <div class="gist-status">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-title alert-success" style="padding: 15px; text-align: center; font-weight: normal; font-size: 16px;">
                                        All Student
                                    </div>
                                    <div class="card-body alert-success" style="padding: 15px; text-align: center; font-weight: bold; font-size: 24px; margin-bottom: 5px;">
                                    <?php
                                        $sql = "SELECT * FROM tblstudent";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        echo $result;
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-title alert-warning" style="padding: 15px; text-align: center; font-weight: normal; font-size: 16px;">
                                        User's
                                    </div>
                                    <div class="card-body alert-warning" style="padding: 15px; text-align: center; font-weight: bold; font-size: 24px; margin-bottom: 5px;">
                                    <?php
                                        $sql = "SELECT * FROM tbluser";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        echo $result;
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-title alert-info" style="padding: 15px; text-align: center; font-weight: normal; font-size: 16px;">
                                        Department
                                    </div>
                                    <div class="card-body alert-info" style="padding: 15px; text-align: center; font-weight: bold; font-size: 24px; margin-bottom: 5px;">
                                    <?php
                                        $sql = "SELECT * FROM tbldepartment";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        echo $result;
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-title alert-danger" style="padding: 15px; text-align: center; font-weight: normal; font-size: 16px;">
                                        Faculty
                                    </div>
                                    <div class="card-body alert-danger" style="padding: 15px; text-align: center; font-weight: bold; font-size: 24px; margin-bottom: 5px;">
                                    <?php
                                        $sql = "SELECT * FROM tblfaculty";
                                        $query_result = mysqli_query($conn, $sql);
                                        $result = mysqli_num_rows($query_result);
                                        echo $result;
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>All Student</h4>
                            <hr>
                            <?php
                                $sql = "SELECT * FROM tblstudent ORDER BY surname ASC";
                                $query_result = mysqli_query($conn, $sql);
                                $result = mysqli_num_rows($query_result);
                                    if($result > 0){
                                        while($row = mysqli_fetch_array($query_result)){
                            ?>
                            <div class="col-md-2">
                                <a  href="view_profile.php?id=<?php echo $row['matricno']; ?>&key=<?php echo uniqid(); ?>">
                                    <div class="thumbnaili" style="border: none;"><img src="../images/profile_pic/<?php echo $row['image']; ?>" class="img-circle"  width="80" height="80">
                                        <div class="caption">
                                            <h5 class="text-center"><?php echo $row['surname'] ." ". $row['othername']; ?></h5>
                                            <h6 class="text-center"><?php echo $row['level']; ?></h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </section>
    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/script.html') ?>
</body>

</html>