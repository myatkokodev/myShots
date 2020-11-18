<?php
require("functions.php");
flash($_POST);
$errors = array();
 if(isset($_POST['signup'])){
    $new_user = array();

    //validate name
    if(empty($_POST['name']) || strlen($_POST['name']) < 3){
        $errors['name'] = "Name must be at least 3characters in length.";
    }else{
        $new_user['name'] = $_POST['name'];
    }

    //validate email
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Please provide a valid email address.";
    }else{
        $new_user['email'] = $_POST['email'];
        if(checkEmail($_POST['email'])){
            $errors['email'] = "Email address is already in use!.";
        }
    }

    //validate password
    if(empty($_POST['password']) || strlen($_POST['password']) < 8){
        $errors['password'] = "Password must be at least 8 characters in length.";
    }else{
        $new_user['password'] = $_POST['password'];
    }
    
    //validate category
    if($_POST['password']!=$_POST['confirm_password']){
        $errors['confirm_password'] = "Passwords do not match.";
    }else{
        $new_user['confirm_password'] = $_POST['confirm_password'];
    }

    if(count($errors) == 0){
        //pretty_print($new_post);
        //insert into db
        if(createUser($new_user)){
            header("Location:signin.php");
        }else{
            $errors['save'] = "somethng went wrong while siginig up.Please try again.";
        }


    }

 }          

?>





<?php require_once("includes/header.php"); ?>

<!-- checking error -->
<?php if(isset($errors['save'])): ?>
    <p class="alert alert-danger"><?php echo $errors['save']; ?></p>
<?php endif; ?>


<div class="container">
    <form class="form-signin my-5" action="" method="post">
        <div class="text-center mb-4">
            <img class="mb-4" src="assets/img/gallery.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Join Kalay Gallery</h1>
            <p>Share your breath taking shots of Kalay Region</p>
        </div>

        <div class="form-label-group">
            <input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?php echo old('name'); ?>">
            <label>Your Name</label>
            <?php if(isset($errors['name'])): ?>
                <p class="text-danger"><?php echo $errors['name']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-label-group">
            <input type="text" name="email" class="form-control" placeholder="Email address" value="<?php echo old('email'); ?>">
            <label>Your Email</label>
            <?php if(isset($errors['email'])): ?>
                <p class="text-danger"><?php echo $errors['email']; ?></p>
            <?php endif; ?>
        </div>
        <div class="form-label-group">
            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo old('password'); ?>">
            <label>Password</label>
            <?php if(isset($errors['password'])): ?>
                <p class="text-danger"><?php echo $errors['password']; ?></p>
            <?php endif; ?>

        </div>
        <div class="form-label-group">
            <input type="password" name="confirm_password" class="form-control" placeholder="Type passwrod again" value="<?php echo old('confirm_password'); ?>">
            <label>Confirm Password</label>
            <?php if(isset($errors['confirm_password'])): ?>
                <p class="text-danger"><?php echo $errors['confirm_password']; ?></p>
            <?php endif; ?>
        </div>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup">Sign Up</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2020 All Rights Reserved</p>
    </form>


</div>

<?php require_once("includes/footer.php"); ?>