<?php
require("functions.php");

if(isset($_GET['id']) &&  !empty($_GET['id'])){
    $id = (int) $_GET['id'];

    $post = getPostById($id);
    pretty_print($post);
    pretty_print($_SESSION['loggedin']);

    if(!$post || !isset($_SESSION['loggedin']) || $post['user_id']!=$_SESSION['loggedin']['id']){
        //you do not have connection to do that
         return header("Location:index.php?err=ErrorPermissin");//return needed
    }
     if(deletePost($id)){
        header("Location:index.php");
     }else{
         //TODO : error message
        header("Location:index.php?err=delete");
     }
}