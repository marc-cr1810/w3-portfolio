<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');

$user_id = Login::isLoggedIn();

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    $exists = $db->querySingle("SELECT EXISTS(SELECT ID FROM Projects WHERE ID=$id);");
    
    if (isset($_POST['create']) and !$exists)
    {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $git = $_POST['git'];
        $user_id = Login::isLoggedIn();
        $image = './images/base_image.jpg';
        
        // Probably store this value with each user? Would involve locatization
        date_default_timezone_set("Australia/Canberra");
        $date = date("Y-m-d H:i:s");

        $db->exec("INSERT INTO Projects VALUES($id, '$title', '$desc', $user_id, '$git', '$image', '$date', '$date');");
        $exists = true;
    }

    if ($exists)
    {
        $project = $db->querySingle("SELECT * FROM Projects WHERE ID=$id;", true);
        
        $title = $project['Title'];
        $desc = $project['Description'];
        $user_id = $project['UserID'];
        $git = $project['GitRepo'];
        $image = $project['Image'];
        $dateCreated = $project['DateCreated'];
        $dateUpdated = $project['DateUpdated'];
    }
    else
    {
        echo 'Invalid project';
    }
}
else
{
    echo '<meta http-equiv="refresh" content="0; URL=https://marccr.w3spaces.com/projects.php" />';
}
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

.w3-bar .w3-button {
  padding: 16px;
}
</style>
</head>
<body class='w3-grey'>

<?php include "./includes/html/navbar.html"; ?>
<?php include "./includes/html/sidebar.html"; ?>

<div class="w3-container" style="padding:72px 64px">
    <div class="w3-container w3-white" stype="padding:16px 64px">
      <?php
      echo '
      <a href="' . $git . '">
        <i class="fa fa-github w3-hover-opacity w3-xxxlarge w3-right w3-margin"></i>
      </a>';
      echo '<h1>' . $title . '</h1>';
      echo '<p class="w3-text-grey">Created by ' . $db->querySingle("SELECT Name FROM Users WHERE ID=$user_id;") . 
        ' at ' . date("h:ia M d Y", strtotime($dateCreated)) . '</p>';
      echo '<img src="' . $image . '" class="w3-right" style="margin:0px 16px 16px;width:40%"></image>';
      echo '<p>' . $desc . '<p />';
      ?>
    </div>
    <div class="w3-container w3-light-grey" style="padding: 32px 16px">
      <h1 class="w3-center">Blog</h1>
      <?php
      if ($user_id)
      {
        echo '<p class="w3-center">';
        echo '<button class="w3-button w3-round w3-white" style="width:30%">Create Blog Post</button>';
        echo '</p>';
      }

      if ($db->querySingle("SELECT COUNT(*) FROM Blogs;"))
      {
        echo 'Blog posts here!';
      }
      else
      {
        echo '<p class="w3-center">No blogs currently posted</p>';
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