<?php require("functions.php"); ?>
<?php

    $search = NULL;
    $posts=getPosts();
    
    $suggestions = [];
    if($loggedInUser = isLoggedIn()){
        $suggestions = getSuggestedUsers($loggedInUser['id']);
    }


?>

<?php require_once("includes/header.php"); ?>


<div class="container">
    <div class="row">
        <div class="col-md-8 main py-5">
            <div id="posts-wrapper">
                <?php foreach($posts as $post): ?>
                    <?php require("includes/card.php"); ?>
                <?php endforeach; ?>
            </div><!--end of post wrapper-->
            <img src="assets/img/loader.gif" id="loader" alt="Loading..." style="width:40px;margin:0px auto;display:none;" />
        </div><!--end of main-->
        <!--info-->
        <div class="col-md-4 sidebar d-none d-sm-block mt-5 mb-0">
            <div class="mt-5 mb-2 row">
                <div class="p-img ml-3 overflow-hidden rounded-circle"
                style="background-image: url('uploads/users/<?php echo $_SESSION['loggedin']['photo']; ?>');">
                </div>
                <div class="py-2 px-2 text-muted">
                    <a class="text-dark" href="account.php"><?php echo isLoggedIn()? $_SESSION['loggedin']['name']:false; ?></a>
                </div>
            </div>
            <?php if(count($suggestions)>0): ?>
                <div class="suggestion_box pb-3 pl-3 pr-3 pt-3 position_right">
                    <div class="row display-6 justify-content-between px-3 pb-3">
                        <span class="text-muted ">Suggection for you</span>
                        <span class="text-primary">See All</span>
                    </div>

                    <?php foreach($suggestions as $user): ?>
                    <div class="row display-6 justify-content-between px-3">
                        <div class="row px-3">
                            <img class="mt-2" src="uploads/users/<?php echo $user['photo']; ?>" alt="" style="width: 40px; height: 40px;">
                            <p class="px-2 "><a href="profile.php?profile_id=<?php echo $user['id']; ?>" class="text-dark"><?php echo $user['name']; ?></a><br><span class="text-muted pt-0" style="font-size:13px;">@<?php echo $user['name']; ?></span></p>
                        </div>
                        <form action="follow.php" method="POST">
                            <input type="hidden" name="following_id" value="<?php echo $user['id']; ?>">
                            <div class="mt-3"><button  type="submit" name="follow" class="btn btn-link">follow</button></div>
                        </form>
                    </div>
                    <?php endforeach; ?>
                    
                </div>
            <?php endif; ?>

        </div><!--end of main-->
    </div><!--end of sidebar-->
</div><!--end of container-->


  
  <?php require_once("includes/footer.php"); ?>