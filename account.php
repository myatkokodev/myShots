<?php

require("functions.php");

$errors = array();

$user = findUserById($_SESSION['loggedin']['id']);
//pretty_print($find_user_byid);
if(isset($_POST['save'])){

    $new_info = array();

    if(empty($_POST['name'])){
        $errors['name'] = $_POST['name'];
    }else{
        $new_info['name'] = $_POST['name'];
    }

    if(isset($_POST['bio'])){
        $new_info['bio'] = $_POST['bio'];
    }

    $id =  $_POST['edited_id'];
    if(count($errors) == 0){

        if(!empty($_FILES['photo']['name'])){
            $filename = time()."-".rand(111111,999999)."-".$_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'],"uploads/users/".$filename);
            $new_info['photo'] = $filename;
        }

        if(updateInfo($id,$new_info)){
            header("Location:index.php");
        }else{
            $errors['save'] = "Something wrong while saving this post!please try again!";
        }
    }



}


?>
    
    
<?php require_once("includes/header.php"); ?>



<div class="container pt-5 col-sm-8 col-md-8 col-lg-6">
    <form action="" method="POST" class="pt-5" enctype="multipart/form-data">
        <div class="form-group upload_profile">
            <img id="upload_profile" src="uploads/users/<?php echo $user['photo']; ?>" alt=" " style="width:150px;mragin:0px;cursor:pointer;border-radius:2rem;border:none;"/>
            <input type="file" id="profile_uploader" name="photo" class="d-none">
            <?php if(isset($errors['photo'])): ?>
                <p class="text-danger"><?php echo $errors['photo']; ?></p>
            <?php endif; ?>
        </div>
        <input type="hidden" name="edited_id" value="<?php echo $user['id']; ?>">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>"/>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" value="<?php echo $user['email']; ?>" readonly/>
        </div>
        <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" class="form-control"><?php echo $user['bio']; ?></textarea>
        </div>

        <div class="form-group">
            <button name="save" class="btn btn-primary">Save</button>
        </div>
    </form>

    <form action="logout.php" method="POST">
            <button name="logout" onclick="return confirm('Are you sure to logout?');" class="btn btn-outline-primary">Logout</button>
    </form>
</div>


<?php require_once("includes/footer.php"); ?>

<script>

    var imgEl = $("#upload_profile");
    var fileEl = $("#profile_uploader");

    //handle on click event on image
    imgEl.on("click",function(event){
        fileEl.trigger("click");
    });

    //handle on file change
    fileEl.on("change",function(event){
        readURL(this);
    });


    function readURL(input){
        //check if any file is chosen
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imgEl.attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>