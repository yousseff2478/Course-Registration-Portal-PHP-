<?php
    #include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/redirect.php');

    session_destroy();
    session_start();
    RedirectTo('index.php');

?>