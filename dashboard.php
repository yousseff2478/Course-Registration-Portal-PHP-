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
    <title>Dashboard</title>
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
                    <div class="gist-status">
                        <div class="row" style="margin: 0px;">
                            <h4>Print Course Form </h4>
                            <hr>
                            <!--
                            <div class="col-md-3">
                                <a  href="#">
                                    <div class="thumbnaili" style="border: none;"><img src="images/profile_pic/1578407312075.jpg" class="img-circle"  width="140" height="140">
                                        <div class="caption">
                                            <h5 class="text-center">Afolabi Temidayo Timothy</h5>
                                            <p class="text-center">Afolabi8120@gmail.com</p>
                                        </div>
                                    </div>
                                </a>
                            </div>-->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="color: #999">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Semester </th>
                                                <th>Session</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $i = 0;
                                            $sql = "SELECT semester, session FROM tbl_submitted_courses WHERE matricno = '{$_SESSION['matricno']}' AND status = 'Submitted' GROUP BY semester, session ORDER BY semester, session ASC ";
                                            $query_result = mysqli_query($conn, $sql);
                                            $result = mysqli_num_rows($query_result);
                                            if($result > 0){
                                                while($rows = mysqli_fetch_array($query_result)){
                                                    $i++;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $rows['semester']; ?></td>
                                                <td><?php echo $rows['session']; ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" target="_blank" href="print.php?sid=<?php echo $_SESSION['matricno']; ?>&session=<?php echo $rows['session']; ?>&semester=<?php echo $rows['semester']; ?>"><span style="color: black;"><i class="fa fa-print"></i></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
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