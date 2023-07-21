<?php
$uri = htmlspecialchars($_SERVER['REQUEST_URI']);

echo $uri;

$nav_home = ($uri == '/' ? '#home' : '/');
$nav_about = ($uri == '/' ? '#about' : '/#about');
$nav_projects = ($uri == '/' ? '#projects' : '/#projects');
$nav_contact = ($uri == '/' ? '#contact' : '/#contact');
?>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <div class="w3-bar w3-white w3-card" id="myNavbar">
        <a href="<?= $nav_home ?>" class="w3-bar-item w3-button w3-wide">LOGO</a>
        <!-- Right-sided navbar links -->
        <div class="w3-right w3-hide-small">
            <a href="<?= $nav_about ?>" class="w3-bar-item w3-button">ABOUT</a>
            <a href="<?= $nav_projects ?>" class="w3-bar-item w3-button"><i class="fa fa-th"></i> PROJECTS</a>
            <a href="<?= $nav_contact ?>" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i> CONTACT</a>
        </div>
        <!-- Hide right-floated links on small screens and replace them with a menu icon -->

        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
            onclick="w3_open()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>