<?php

    require("functions.php");
    $profile_id = isset($_GET['profile_id'])?(int)$_GET['profile_id']:0;
    if(!$profile_id){
        return header("Location:index.php");
    }
    $user = finduserById($profile_id);

    if(!$user){
        return header("Location:index.php");
    }

    $posts = getPosts(null,9,$profile_id);

    $get_follower = getFollowerCount($profile_id);
    $get_following = getFollowingCount($profile_id);
    $get_total_posts = getPostCount($profile_id);


    $is_following = false;
    if($loggedInUser = isLoggedin()){//this is conditional assignment
        $is_following = isFollowing($loggedInUser['id'],$profile_id);
    }

?>






<?php require("includes/header.php"); ?>
<div class="container" id="profile">
       <div class="column col-md-12">
            <div class="col-md-12 justify-content-center" id="profile-img">
                <img class="rounded-circle" src="uploads/users/<?php echo $user['photo']; ?>" alt="">
            </div>
            <div class="col-md-12" id="profile-info">
                <div class="row justify-content-center mt-3">
                    <h3 class="text-muted"><?php echo $user['name']; ?></h3>
                        <?php if($loggedInUser=isLoggedin() && $profile_id != $loggedInUser['id']): ?>
                            <form action="follow.php" method="POST">
                                <input type="hidden" name="following_id" value="<?php echo $user['id']; ?>">
                                <?php if($is_following): ?>
                                    <button type="submit" name="unfollow" class="social-button follow-btn ml-3">following</button>
                                <?php else: ?>
                                    <button  type="submit" name="follow" class="social-button follow-btn ml-3">follow</button>
                                <?php endif;?>
                            </form>`
                        <?php endif; ?>
                </div>
                <div class="row py-3 justify-content-center" id="followers">
                    <span><?php echo count($get_total_posts); ?> posts</span>
                    <span><?php echo count($get_follower); ?> followers</span>
                    <span><?php echo count($get_following); ?> following</span>
                </div>
                <div id="biography" class="col-md-12">
                    <h4 class="text-center text-center">BIOGRAPHY</h4>
                    <p class="text-muted text-center"><?php echo $user['bio']; ?><p>
                </div>
                
            </div>
       </div>


       <div id="items">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Follwoing page</a>
                </li>
            </ul>
       </div>

       <div id="posts">
            <div class="row">
                <?php foreach($posts as $post): ?>
                    <div class="col-md-6 my-3 col-lg-4">
                        <div class="post-item" style="background-image:url('uploads/<?php echo $post['photo']; ?>');">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
       </div>
</div>

<script>
</script>
<?php require("includes/footer.php"); ?>



