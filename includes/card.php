

<!-- Card Wider -->
<div class="post-card card card-cascade wider my-5" data-id="<?php echo $post["id"]; ?>">

        <!-- Card image -->
        <div class="view view-cascade overlay">
                <div class="actions">
                        <?php if(isset($_SESSION['loggedin']) && $post['user_id'] == $_SESSION['loggedin']['id']): ?>
                                <a onclick="return confirm('Are you sure to delete?');" href="delete.php?id=<?php echo $post['id']; ?>" class="delete-icon"><i class="fas fa-times-circle"></i></a>
                        <?php endif; ?>
                </div>
                <img class="card-img-top" src="uploads/<?php echo $post['photo']; ?>"  alt="Card image cap">
                <a href="#!">
                   <div class="mask rgba-white-slight"></div>
                </a>
        </div>

                <!-- Card content -->
        <div class="card-body card-body-cascade text-center">

                <!-- Title -->
                <h4 class="card-title blue-text pb-2"><strong><a href="profile.php?profile_id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></strong></h4>
                <!-- Subtitle -->
                <!-- <h5 class="blue-text pb-2"><strong>Graffiti Artist</strong></h5> -->
                <!-- Text -->
                <p class="card-text post-desc"><?php echo $post['description']; ?> </p>

                <!-- Linkedin -->
                <a href="#" class="px-2 fa-lg li-ic"><i class="fab fa-linkedin-in"></i></a>
                <!-- Twitter -->
                <a href="#" class="px-2 fa-lg tw-ic"><i class="fab fa-twitter"></i></a>
                <!-- Dribbble -->
                <a href="#" class="px-2 fa-lg fb-ic"><i class="fab fa-facebook-f"></i></a>

        </div>

</div>
<!-- Card Wider -->

<template id="card_tpl">

<!-- Card Wider -->
        <div class="post-card card card-cascade wider my-5" data-id="{{post_id}}">
                
                <div class="actions"></div>
                <!-- Card image -->
                <div class="view view-cascade overlay">
                        <img class="card-img-top card-photo" src="uploads/{{post_photo}}"  alt="Card image cap">
                        <a href="#">
                                <div class="mask rgba-white-slight"></div>
                        </a>
                </div>

                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">

                        <!-- Title -->
                        <h4 class="card-title blue-text pb-2"><strong><a href="#">{{name}}</a></strong></h4>
                        <!-- Subtitle -->
                        <!-- <h5 class="blue-text pb-2"><strong>Graffiti Artist</strong></h5> -->
                        <!-- Text -->
                        <p class="card-text post-desc">{{description}}</p>

                        <!-- Linkedin -->
                        <a href="#" class="px-2 fa-lg li-ic"><i class="fab fa-linkedin-in"></i></a>
                        <!-- Twitter -->
                        <a href="#" class="px-2 fa-lg tw-ic"><i class="fab fa-twitter"></i></a>
                        <!-- Dribbble -->
                        <a href="#" class="px-2 fa-lg fb-ic"><i class="fab fa-facebook-f"></i></a>

                </div>

        </div>
<!-- Card Wider -->

</template>