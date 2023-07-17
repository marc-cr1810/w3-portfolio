<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Portfolio - Projects</title>
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

.prjimg {
  width: 100%;
  height: 225px;
  object-fit: cover;
  overflow: hidden;
}

.w3-bar .w3-button {
  padding: 16px;
}
    
.mySlides {
  display: none
}

.w3-tag,.fa {
  cursor: pointer
}

.w3-tag {
  height: 15px;
  width: 15px;
  padding: 0;
  margin-top: 6px
}

.w3-row-padding {
  display: table !important;
  width: 100% !important;
}

.w3-col {
  display: block !important;
  float: none !important;
}

@media (min-width: 601px) {
  .w3-col {
    display: table-cell !important;
    width: 50%;
    
  }
}
</style>
</head>
<body class='w3-white'>

<?php include "./includes/html/navbar.html"; ?>
<?php include "./includes/html/sidebar.html"; ?>

<div class="w3-center" style="margin-top: 60px">
  <div style="padding:16px 16px" id="home">
    <h1>Projects</h1>
    
    <?php
    $login_info = Login::isLoggedIn();
    if ($login_info)
    {
      echo '<p>Logged in as ' . $db->querySingle("SELECT Name FROM Users WHERE ID=$login_info;") . '</p>';
      echo '<p class="w3-center">';
      echo '<a href="create_project.php">';
      echo '<button class="w3-button w3-round w3-light-grey" style="width:30%">Create New Project</button>';
      echo '</a></p>';
    }
    ?>
  </div>
  <div class="w3-light-grey" style="padding:64px 16px">
    <?php
    $index = 0;
    $projects = $db->query("SELECT * FROM Projects ORDER BY DateUpdated DESC;");
    while ($row = $projects->fetchArray(SQLITE3_ASSOC))
    {
      if (($index % 3) == 0)
      {
        if ($index != 0)
        {
          echo '</div>';
          echo '<div class="w3-row-padding" style="margin-top: 32px">';
        }
        else
        {
          echo '<div class="w3-row-padding">';
        }
      }
      echo '<div class="w3-col l4 m6 w3-margin-bottom">';
      echo '<div class="w3-card w3-white">';
      echo '<img src="' . $row['Image'] . '" alt="ProjectImage" class="prjimg">';
      echo '<div class="w3-container">';
      echo '<h2>' . $row['Title'] . '</h2>';
      echo '<p>' . $row['Description'] . '</p>';
      echo '<p><a href="project.php?id=' . $row['ID'] . '"><button class="w3-button w3-light-grey w3-round w3-block">View Project</button></a></p>';
      echo '</div></div></div>';
      $index += 1;
    }
    ?>
  </div>
</div>

<!-- Footer -->
<?php include("./includes/html/footer.html"); ?>

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