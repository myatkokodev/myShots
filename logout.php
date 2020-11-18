<?php
    require("functions.php");

    if(isset($_POST['logout'])){
        //clear all session
        unset($_SESSION['loggedin']);
        //session_destroy();
        header("Location:signin.php");
    }
 

?>