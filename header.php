<?php
  include 'config.php';
  $page = basename($_SERVER['PHP_SELF'],".php");
  $select = "SELECT * FROM categories";
  $query = mysqli_query($config, $select);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body style="background-color: #edeef0;">
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'index')? 'active': ''; ?>" href="index.php">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
          <div class="dropdown-menu">
            <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
            <a class="dropdown-item" href="category.php?id=<?= $cats['category_id'] ?>">
              <?= $cats['category_name'] ?>
            </a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'login')? 'active': ''; ?>" href="login.php">
            Login
          </a>
        </li>
      </ul>
      <?php
        if (isset($_GET['keyword'])) 
        {
          $keyword = $_GET['keyword'];
        }
        else
        {
          $keyword = "";
        }
      ?>
      <form class="d-flex" action="search.php" method="GET">
        <input class="form-control me-sm-2" type="search" placeholder="Search" name="keyword" required maxlength="70" autocomplete="off" value="<?= $keyword ?>">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
    