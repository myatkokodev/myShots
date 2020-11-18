<?php 
require("functions.php");

//follow
if(isset($_POST['follow']) && !empty($_POST['following_id']) && isLoggedin()){

$followingID=$_POST['following_id'];
$followerID = $_SESSION['loggedin']['id'];

if(follow($followerID,$followingID)){
//pretty_print($_SERVER);//all information
    header("Location:".$_SERVER['HTTP_REFERER']);
}else{
    header("Location:index.php?err=follow");
}
}

//unfollow
if(isset($_POST['unfollow']) && !empty($_POST['following_id']) && isLoggedin()){

    $followingID=$_POST['following_id'];
    $followerID = $_SESSION['loggedin']['id'];
    
    if(unFollow($followerID,$followingID)){
    //pretty_print($_SERVER);//all information
        header("Location:".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location:index.php?err=unfollow");
    }
    
    
    }

