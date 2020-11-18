
<?php 

    require("functions.php");
    $errors = array();

    if(isset($_POST['submit'])){
        $new_post = array();
        //validate photo
        if(empty($_FILES['photo']['name'])){
            $errors['photo'] = "Please provide a photo first.";
        }

         //validate description
         if(empty($_POST['description'])){
            $errors['description'] = "Please provide a caption for this masterpiece.";
        }

        if(count($errors) == 0){
            //ok
            $new_post['description'] = $_POST['description'];
            $filename = time()."-".rand(111111,999999)."-".$_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'],"uploads/".$filename);
            $new_post['photo'] = $filename;
            $new_post['user_id'] = $_SESSION["loggedin"]["id"];
            //save into db
            if(createPost($new_post)){
                header("Location:index.php");
            }else{
                //something went wrong
                $errors['save'] = "Something went wrong while sumbmitting your masterpiece";
            }

            //save in the db

        }
    }

?>
<?php require_once("includes/header.php"); ?>

<div class="container py-5">

    <form class="py-5 upload-form" action="" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <h3 class="text-center text-primary"> Uploaded a Master 
        </div>

        <div class="form-group upload-image">
            <img id="uploaded_img" src="assets/img/camera.png" alt=""/> 
            <input type="file" id="file_uploader" name="photo" class="d-none">
            <?php if(isset($errors['photo'])): ?>
            <p class="text-danger"><?php echo $errors['photo']; ?></p>
            <?php endif; ?>

        </div>
    
        <div class="form-group">
            <textarea name="description" class="form-control" row="3"></textarea>
            <?php if(isset($errors['description'])): ?>
            <p class="text-danger"><?php echo $errors['description']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button class="btn btn-block btn-primary" name="submit">Post</button>
        </div>
    </form>

</div>

<?php require_once("includes/footer.php"); ?>

<script>

    var imgEl = $("#uploaded_img");
    var fileEl = $("#file_uploader");

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