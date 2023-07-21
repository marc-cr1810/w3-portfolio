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
        <h1>Login</h1>
        
        <?php
        $login_success = false;
        $msg = "";

        $login_info = Login::isLoggedIn();
        if ($login_info)
        {
            echo '<p>Already logged in as ' . $db->querySingle("SELECT Name FROM Users WHERE ID=$login_info;") . "</p>";
            echo '<a href="logout.php"><button class="w3-button w3-light-gray">Logout?</button></a>';
        }
        else
        {
            if (isset($_POST['login'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                if ($db->querySingle("SELECT EXISTS(SELECT 1 FROM Users WHERE Username='$username');"))
                {
                    if (password_verify($password, $db->querySingle("SELECT Password FROM Users WHERE Username='$username';", true)['Password']))
                    {
                        echo '<p>Logged in!</p>';
                        $login_success = true;
                        $cstrong = true;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $sha1_token = sha1($token);
                        $user_id = $db->querySingle("SELECT id FROM Users WHERE Username='$username';", true)['ID'];
                        $db->query("INSERT INTO LoginTokens VALUES ('$sha1_token', $user_id);");

                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', "", TRUE, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', "", FALSE, TRUE);
                    }
                    else
                    {
                        $msg = '<p>Incorrect password!</p>';
                    }
                }
                else
                {        
                    $msg = '<p>Invalid login!</p>';
                }

            }

            if (!$login_success)
            {
                echo '<form action="login.php" method="post">';
                echo '<input class="w3-input w3-border" type="text" name="username" value="" placeholder="Username"><p />';
                echo '<input class="w3-input w3-border" type="password" name="password" value="" placeholder="Password"><p />';
                if (!empty($msg))
                    echo $msg;
                echo '<input class="w3-button w3-light-grey" type="submit" name="login" value="Login">';
                echo '</form>';
            }
            else
            {
                echo $msg;
            }
        }
        ?>
    </div>
</div>
<script>
// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>