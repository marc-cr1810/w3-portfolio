<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');
include('./includes/php/utils.php');
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

<?php
$user_id = Login::isLoggedIn();

if (isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $exists = $db->querySingle("SELECT EXISTS(SELECT ID FROM Blogs WHERE ID=$id);");
    
    if (isset($_POST['create']) and isset($_GET['project_id']) and !$exists)
    {
        $project_id = htmlspecialchars($_GET['project_id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $git = htmlspecialchars($_POST['git']);
        $image = './images/base_image.jpg';
        
        // Probably store this value with each user? Would involve locatization
        date_default_timezone_set("Australia/Canberra");
        $date = date("Y-m-d H:i:s");

        $db->exec("INSERT INTO Blogs VALUES($id, $project_id, $user_id, '$date', '$title', '$content', '$git', '$image')");
        $db->exec("UPDATE Projects SET DateUpdated='$date' WHERE ID=$project_id");
        $exists = true;
    }

    if ($exists)
    {
        $blog = $db->querySingle("SELECT * FROM Blogs WHERE ID=$id", true);

        $project_id = $blog['ProjectID'];
        $creator_id = $blog['UserID'];
        $dateCreated = $blog['DateCreated'];
        $title = $blog['Title'];
        $content = formatContent($blog['Content']);
        $git = $blog['GitCommit'];
        $image = $blog['Image'];
    }
    else
    {
        echo 'Invalid blog';
    }
}
else
{
    echo '<meta http-equiv="refresh" content="0; URL=https://marccr.w3spaces.com/projects.php" />';
}
?>

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
        echo '<a href="project.php?id=' . $project_id . '"><h5>' . $db->querySingle("SELECT Title FROM Projects WHERE ID=$project_id") . '</h5></a>';
        echo '<h1>' . $title . '</h1>';
        echo '<p class="w3-text-grey">Created by ' . $db->querySingle("SELECT Name FROM Users WHERE ID=$creator_id;") . 
            ' at ' . date("h:ia M d Y", strtotime($dateCreated)) . '</p>';
        echo '<p>' . $content . '</p>';
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