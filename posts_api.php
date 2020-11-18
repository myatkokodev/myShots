<?php 

require("functions.php");


if(isset($_GET['last_id'])){
    $last_id = (int) $_GET['last_id'];
    $posts = getPosts($last_id);
    header('Content-Type: application/json');
    echo json_encode($posts);
}



?>