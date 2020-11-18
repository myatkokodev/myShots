<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css" />

    <!--font awesome link-->
    <script src="assets/js/8e68352e43.js"></script>

    <title>Kalay Gallery!</title>
  </head>
  <body>

<nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
  <a class="navbar-brand text-light" href="index.php">KalayGallery</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon navbar-toggler"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">

      <?php if(!isset($_SESSION['loggedin'])): ?>
        <li class="nav-item d-lg-none d-block my-2">
          <a class="btn btn-link text-light" href="signin.php">Sign in</a>
        </li>
        <li class="nav-item d-lg-none d-block">
          <a class="btn btn-link text-light" href="signup.php">Sign up</a>
        </li>
      <?php endif;?>
    </ul>

    <span class="navbar-text">
      <?php if(isset($_SESSION['loggedin'])): ?>
      <a href="account.php" style="color: pink;">Welcome,<?php echo $_SESSION['loggedin']['name']; ?></a>
      <a  href="upload.php" class="btn btn-light mx-3">Upload your shot</a>
      <?php else: ?>

        
      <a class="btn btn-link d-none text-light d-lg-inline" href="signup.php">Sign up</a>
      <a class="btn btn-link text-light d-none d-lg-inline" href="signin.php">Sign in</a>
    <?php endif; ?>
    </span>
  </div>

  <script>
      var loggedInID = <?php echo isset($_SESSION['loggedin']) ? $_SESSION['loggedin']['id']:0; ?>;
  </script>
</nav>
