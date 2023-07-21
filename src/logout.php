<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Portfolio</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
  scroll-behavior: smooth;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
  background-size: cover;
  background-image: url("images/game-programming-blur.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>
</head>
<body class='w3-grey'>

<?php include "./includes/html/navbar.php"; ?>
<?php include "./includes/html/sidebar.php"; ?>

<div class="w3-container w3-grey" style="padding:128px 64px">
    <div class="w3-card w3-white w3-padding-large w3-margin-small">
        <?php
        if (isset($_POST['confirm']))
        {
            if (isset($_COOKIE['SNID']))
            {
                $sha1_snid = sha1($_COOKIE['SNID']);
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
                $db->exec("DELETE FROM LoginTokens WHERE Token='$sha1_snid'");
            }
        }

        echo '<h1>Logout</h1>';
        if (!Login::isLoggedIn())
        {
            echo '<p>Not logged in</p>';
            echo '<a href="login.php"><button class="w3-button w3-light-gray">Login?</button></a>';
        }
        else
        {
            echo '<p>Are you sure you\'d like to logout?</p>';
            echo '<form action="logout.php" method="post">';
            echo '<input class="w3-button w3-light-grey" type="submit" name="confirm" value="Confirm">';
            echo '</form>';
        }
        ?>
    </div>
</div>