<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');

if (!Login::isLoggedIn())
{
    die("Not logged in");
}

$project_id = $db->querySingle("SELECT COUNT(*) as count FROM Projects") + 1;
?>

<h1>Create Project</h1>
<?= '<form action="project.php?id=' . $project_id . '" method="post" enctype="multipart/form-data">' ?>
    <input type="text" name="title" value="" placeholder="Project Title" /><p />
    <textarea name="description" rows="8" cols="80"></textarea><p />
    <input type="text" name="git" value="" placeholder="Git Repo" /><p />
    <p>Upload an image:</p>
    <input type="file" name="img" /><p />
    <input type="submit" name="create" value="Create" />
</form>