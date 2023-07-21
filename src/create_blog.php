<?php
include('./includes/php/w3_preview_check.php');
include('./includes/php/database.php');
include('./includes/php/login.php');

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    $user_id = Login::isLoggedIn();
    $exists = $db->querySingle("SELECT EXISTS(SELECT ID FROM Projects WHERE ID=$id);");
    if ($exists)
    {
        $project = $db->querySingle("SELECT * FROM Projects WHERE ID=$id", true);
    }
    else
    {
        die("Invalid project ID");
    }
    $blog_id = $db->querySingle("SELECT COUNT(*) as count FROM Blogs") + 1;
}
?>

<h1>Create Blog Post for <?= $project['Title']?></h1>
<p>Logged in as <?= $db->querySingle("SELECT Name FROM Users WHERE ID=$user_id")?></p>

<?= '<form action="blog.php?id=' . $blog_id . '&project_id=' . $id .'" method="post" enctype="multipart/form-data">' ?>
    <input type="text" name="title" value="" placeholder="Blog Title" /><p />
    <textarea name="content" rows="8" cols="80"></textarea><p />
    <input type="text" name="git" value="" placeholder="Git Commit" /><p />
    <p>Upload an image:</p>
    <input type="file" name="img" /><p />
    <input type="submit" name="create" value="Create" />
</form>