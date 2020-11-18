<?php

require("functions.php");
$errors = array();

 if(isset($_POST['signin'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

        //validate email
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Please provide a valid email address.";
    }
    //validate password
    if(empty($password)){
        $errors['password'] = "Password must not be empty.";
    }

    
    if(count($errors) == 0){
        //login
        if(checkLogin($email,$password)){
            header("Location:index.php");
        }else{
            $errors['login'] = "Email and password do not match.";
        }
    }
}

?>




<?php require_once("includes/header.php"); ?>

<div class="container">
<div class="container">
    <form class="form-signin my-5" action="" method="POST">
        <div class="text-center mb-4">
            <img class="mb-4" src="assets/img/gallery.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Join Kalay Gallery</h1>
            <p>Share your breath taking shots of Kalay Region</p>
        </div>

        <div class="form-label-group">
            <input type="text" name="email" class="form-control" placeholder="Email address">
            <label>Your Email</label>
            <?php if(isset($errors['email'])): ?>
                <p class="text-danger"><?php echo $errors['email']; ?></p>
            <?php endif; ?>
        </div>
        <div class="form-label-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <label>Password</label>
            <?php if(isset($errors['password'])): ?>
                <p class="text-danger"><?php echo $errors['password']; ?></p>
            <?php endif; ?>
        </div>
        <?php if(isset($errors['login'])): ?>
                <p class="alert alert-danger"><?php echo $errors['login']; ?></p>
        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="signin">Sign In</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2020 All Rights Reserved</p>
    </form>


</div>
</div>

<?php require_once("includes/footer.php"); ?>