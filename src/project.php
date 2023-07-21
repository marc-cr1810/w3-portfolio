<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');

$user_id = Login::isLoggedIn();

if (isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $exists = $db->querySingle("SELECT EXISTS(SELECT ID FROM Projects WHERE ID=$id);");
    
    if (isset($_POST['create']) and !$exists)
    {
        $title = htmlspecialchars($_POST['title']);
        $desc = htmlspecialchars($_POST['description']);
        $git = htmlspecialchars($_POST['git']);
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
        $creator_id = $project['UserID'];
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
<body class='w3-grey'>

<?php include "./includes/html/navbar.php"; ?>
<?php include "./includes/html/sidebar.php"; ?>

<div class="w3-container" style="padding:72px 64px">
    <div class="w3-container w3-white" stype="padding:16px 64px">
      <?php
      if (!empty($git))
      {
        echo '
        <a href="' . $git . '">
          <i class="fa fa-github w3-hover-opacity w3-xxxlarge w3-right w3-margin"></i>
        </a>';
      }
      echo '<h1>' . $title . '</h1>';
      echo '<p class="w3-text-grey">Created by ' . $db->querySingle("SELECT Name FROM Users WHERE ID=$creator_id;") . 
        ' at ' . date("h:ia M d Y", strtotime($dateCreated)) . '</p>';
      echo '<img src="' . $image . '" class="w3-right" style="margin:0px 16px 16px;width:40%"></image>';
      echo '<p>' . $desc . '<p />';
      ?>
    </div>
    <div class="w3-container w3-light-grey" style="padding: 32px 16px">
      <h1 class="w3-center">Blog</h1>
      <?php
      if ($user_id == $creator_id)
      {
        echo '<p class="w3-center">';
        echo '<a href="create_blog.php?id=' . $id . '">';
        echo '<button class="w3-button w3-round w3-white" style="width:30%">Create Blog Post</button>';
        echo '</a>';
        echo '</p>';
      }

      if ($db->querySingle("SELECT COUNT(*) FROM Blogs WHERE ProjectID=$id;"))
      {
        $index = 0;
        $blogs = $db->query("SELECT * FROM Blogs WHERE ProjectID=$id ORDER BY DateCreated DESC");
        while ($row = $blogs->fetchArray(SQLITE3_ASSOC))
        {
          if (($index % 2) == 0)
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
          echo '<div class="w3-col l6 m6 w3-margin-bottom">';
          echo '<div class="w3-card w3-white">';
          echo '<img src="' . $row['Image'] . '" alt="BlogImage" class="prjimg">';
          echo '<div class="w3-container">';
          echo '<h2>' . $row['Title'] . '</h2>';
          echo '<p class="w3-text-grey">' . date("h:ia M d Y", strtotime($row['DateCreated'])) . '</p>';
          echo '<p><a href="blog.php?id=' . $row['ID'] . '"><button class="w3-button w3-light-grey w3-round w3-block">View Blog</button></a></p>';
          echo '</div></div></div>';
          $index += 1;
        }
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