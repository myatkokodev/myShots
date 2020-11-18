<?php 
//start session

session_start();


function pretty_print($data){
     echo "<pre>";
     print_r($data);
     echo "</pre>";
 }

/*
 save into session for formdata (temporary)
 */

function flash($array){
    $_SESSION['formdata']= $array; 
 }
 /** 
  * output form value stored in session (just one time)
  */
 function old($key){
     $value = isset($_SESSION['formdata'][$key]) ? $_SESSION['formdata'][$key]:null;
     if($value){
         unset($_SESSION['formdata'][$key]);
     }
     return $value;
 }


$dbname = "kalay_gallery";
$servername = "localhost";
$username = "phpdev";
$password = "123456";

//

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);//where the connection 
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

/*
create new user
*/
//createUser(["name"=>"Myat Ko","email"=>"myatkoko.programmer@gmail.com","password"=>"myatkoko"]);


function createUser($new_user){
    global $conn;
    $query="INSERT INTO `users`( `name`, `email`, `password`) 
    VALUES (:name, :email, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":name",$new_user['name']);
    $stmt->bindValue(":email",$new_user['email']);
    $password = password_hash($new_user['password'], PASSWORD_DEFAULT);
    $stmt->bindParam(":password",$password);
    return $stmt->execute();

}
/**
 * Check email
 * */
//pretty_print(checkEmail("myamya@gmail.com"));

 function checkEmail($email){
     global $conn;
     $query = "SELECT * FROM `users` WHERE `email` = :email";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(":email",$email);
     $stmt->execute();
     $stmt->setFetchMode(PDO::FETCH_ASSOC); //for associated arrray
     $user = $stmt->fetch();
     return $user  ? true : false;
    }
/**
 * Check Login
 */

 function checkLogin($email,$password){
     global $conn;
     $query = "SELECT * FROM `users` WHERE `email` = :email";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(":email",$email);
     $stmt->execute();
     $stmt->setFetchMode(PDO::FETCH_ASSOC); //for associated arrray
     $user = $stmt->fetch();
     if(!$user){
         return false;//first test
     }
     //check password
     if(password_verify($password,$user['password'])){
         //save the loggedin state in session
         $_SESSION['loggedin'] = $user;
         return true;
     }else{
         return false;
     }
 }

 /**
  * create NEW pOST
  */
  
function createPost($new_post){
    global $conn;
    $query="INSERT INTO `posts`( `photo`, `description`, `user_id`) 
    VALUES (:photo, :description, :user_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":photo",$new_post['photo']);
    $stmt->bindValue(":description",$new_post['description']);
    $stmt->bindValue(":user_id",$new_post['user_id']);
    return $stmt->execute();
}

/**
 * SELECT posts
 */

//pretty_print(getPosts());
//posts
function getPosts($last_id = null,$limit=3,$user_id=null){
    global $conn;
    $query = "SELECT posts.*,users.name FROM `posts` INNER JOIN `users` ON `users`.id = `posts`.`user_id` ";
    if($last_id){
        $query .= " WHERE `posts`.`id` < :last_id";
    }
    if($user_id){
        $query .= $last_id?"AND":"WHERE";
        $query .= "`posts`.user_id = :user_id";
    }
    $query .= " ORDER BY `posts`.`id` DESC LIMIT :limit ";
    $stmt = $conn->prepare($query);
    if($last_id){
        $stmt->bindParam(":last_id",$last_id);
    }
    if($user_id){
        $stmt->bindParam(":user_id",$user_id);
    }

    $stmt->bindParam(":limit",$limit,PDO::PARAM_INT);
    $stmt->execute();
    // set the resulting array to associative
     //for associated arrray
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateInfo($id,$new_info){
    global $conn;
    $query = "UPDATE `users` SET `name`=:name , `bio` = :bio";

    if(!empty($new_info['photo'])){
        $query .=" ,`photo` = :photo";
    }

    $query .= " WHERE `id` = :id ";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":name",$new_info['name']);
    $stmt->bindParam(":bio",$new_info['bio']);
    $stmt->bindParam(":id",$id);

    if(!empty($new_info['photo'])){
        $stmt->bindParam(":photo",$new_info['photo']);
    }
    return $stmt->execute();
}

/**
 * SELECT post
 */
function getPostById($id){
    global $conn;
    $query = "SELECT * FROM `posts` WHERE `id`=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$id);
   
    $stmt->execute();//scope revolution operator
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function finduserById($id){
    global $conn;
    $query = "SELECT * FROM `users` WHERE `id`=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$id);
   
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);//scope revolution operator
    return $stmt->fetch();
}

function deletePost($id){
    global $conn;
    $query = "DELETE FROM `posts` WHERE `id` = :id";
    $stmt=$conn->prepare($query);
    $stmt->bindParam(":id",$id);
    return $stmt->execute();//true or false if(true)////
}
function getSuggestedUsers($user_id){
    global $conn;

    $exceptions = getFollowings($user_id);
    if(is_array($exceptions)){
        array_unshift($exceptions,$user_id);
    }else{
        $exceptions = [$user_id];
    }
    $placeholders = str_repeat('?,',count($exceptions)-1).'?';
    $query = "SELECT id,name,photo FROM `users`";
    $query .= " WHERE `id` NOT IN($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->execute($exceptions);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//insert to the follower table
 

function follow($follower_id,$following_id){
    global $conn;
    $query = "INSERT INTO `follows`(`follower_id`, `following_id`) VALUES (:followerID,:followingID)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":followerID",$follower_id);
    $stmt->bindParam(":followingID",$following_id);
    return $stmt->execute();
}

function unFollow($followerID,$followingID){
    global $conn;
    $query = "DELETE FROM `follows` WHERE `follower_id` = :follower_id AND `following_id`= :following_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":follower_id",$followerID);
    $stmt->bindParam(":following_id",$followingID);
    return $stmt->execute();

}


function getFollowings($followerID){
    global $conn;
    $query = "SELECT `following_id` FROM `follows` WHERE `follower_id` = :followerID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":followerID",$followerID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);//associate array to arrray
}


function isFollowing($follower_id,$following_id){
    global $conn;
    $query = "SELECT * FROM `follows` WHERE `follower_id` = :follower_id AND `following_id`= :following_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":follower_id",$follower_id);
    $stmt->bindParam(":following_id",$following_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}

function isLoggedin(){
    return isset($_SESSION['loggedin'])?$_SESSION['loggedin']:false;
}


/**
 * count following people
 */
function getFollowingCount($follower_id){
    global $conn;
    $query = "SELECT `following_id` FROM `follows` WHERE `follower_id` = :follower_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":follower_id",$follower_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * count follower people
 */
function getFollowerCount($following_id){
    global $conn;
    $query = "SELECT `follower_id` FROM `follows` WHERE `following_id` = :following_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":following_id",$following_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * count total post
 */

 function getPostCount($user_id){
     global $conn;
     $query = "SELECT `id` FROM `posts` WHERE `user_id` = :user_id";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(":user_id",$user_id);
     $stmt->execute();
     return $stmt->fetchAll(PDO::FETCH_COLUMN);
 }




?>