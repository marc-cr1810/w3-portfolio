<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
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
<body>

<?php include "./includes/html/navbar.html"; ?>
<?php include "./includes/html/sidebar.html"; ?>

<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-left w3-text-white" style="padding:48px">
    <span class="w3-jumbo w3-hide-small">Marc Cooke-Russell</span><br>
    <span class="w3-xxlarge w3-hide-large w3-hide-medium">Marc Cooke-Russell</span><br>
    <span class="w3-large">Software Engineer and Developer</span>
    <div class="w3-horizontal">
      <a href="#projects"><button class="w3-button w3-white w3-padding-small w3-large w3-round w3-margin-top w3-opacity w3-hover-opacity-off">My Projects</button></a>
      <a href="#about"><button class="w3-button w3-white w3-padding-small w3-large w3-round w3-margin-top w3-opacity w3-hover-opacity-off">About me</button></a>
    </div>
  </div> 
  <div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
    <!--<i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>-->
    <a href="https://github.com/marc-cr1810"><i class="fa fa-github w3-hover-opacity"></i></a>
    <a href="https://au.linkedin.com/in/marc-cooke-russell"><i class="fa fa-linkedin w3-hover-opacity"></i></a>
  </div>
</header>

<!-- About Section -->
<div class="w3-container" style="padding:64px 32px" id="about">
  <h3 class="w3-center">ABOUT ME</h3>
  <p class="w3-center w3-large">I am a passionate programmer and software developer. With a deep love for technology and a curiosity that drives me to explore new frontiers, I thrive in the ever-evolving world of coding.

I embarked on my programming journey [number of years] ago, and since then, I have honed my skills in various programming languages and frameworks. My expertise lies in [list your main areas of expertise], and I continually strive to expand my knowledge and stay updated with the latest industry trends.
</p>
<p class="w3-center w3-large">Throughout my career, I have had the pleasure of working on diverse projects, ranging from small-scale applications to large enterprise systems. I believe that every coding challenge presents an opportunity for growth, and I approach each project with enthusiasm and a determination to deliver high-quality solutions.

Collaboration and teamwork are key elements of my work ethic. I thoroughly enjoy working in agile environments, where I can collaborate with cross-functional teams to solve complex problems. I believe in the power of effective communication and believe that it plays a vital role in delivering successful projects.

In addition to my technical skills, I am a strong advocate for clean code, maintainability, and scalability. I take pride in writing elegant and efficient code that not only meets the requirements but also ensures a seamless user experience. I am always eager to learn new techniques and tools that can enhance my coding practices.
</p>
<p class="w3-center w3-large">
Apart from my professional pursuits, I am an avid learner and an explorer. I dedicate time to stay updated with emerging technologies, attend conferences, and engage in online communities to exchange knowledge and ideas with fellow developers.

Ultimately, my goal is to leverage my skills and experience to create innovative software solutions that make a positive impact on people's lives. I am excited about the possibilities that lie ahead, and I am eager to take on new challenges and contribute to transformative projects.</p>
</div>

<!-- Projects Section -->
<div class="w3-container w3-light-grey" style="padding:64px 32px" id="projects">
  <h3 class="w3-center">MY PROJECTS</h3>
  <p class="w3-center w3-large">The projects I have made or been actively working on</p>
  <p class="w3-center">
    <a href="projects.php">
      <button class="w3-button w3-round w3-light-grey" style="width:30%">View All Projects</button>
    </a>
  </p>
  <?php
  $index = 0;
  $projects = $db->query("SELECT * FROM Projects ORDER BY DateUpdated DESC LIMIT 3;");
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

<!-- Contact Section -->
<div class="w3-container w3-dark-grey" style="padding:64px 32px" id="contact">
  <div class="w3-card w3-white w3-padding-large w3-margin-small">
    <h3 class="w3-center">CONTACT</h3>
    <p class="w3-center w3-large">Lets get in touch. Send me a message:</p>
    <div class="w3-center" style="margin-top:48px">
      <p><i class="fa fa-map-marker fa-fw w3-xlarge"></i> Canberra, Australia</p>
      <p><i class="fa fa-envelope fa-fw w3-xlarge"></i> marc.cookerussell@gmail.com</p>
    </div>
    <div class="w3-center w3-xxlarge" style="margin-top:24px">
    <a href="https://github.com/marc-cr1810"><i class="fa fa-github w3-hover-opacity"></i></a>
    <a href="https://au.linkedin.com/in/marc-cooke-russell"><i class="fa fa-linkedin w3-hover-opacity"></i></a>
    </div>
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