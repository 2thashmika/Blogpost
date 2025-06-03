<?php
$title = $author = $content = "";
$title_err = $author_err = $content_err = $image_err = "";
$submitted = false;
$imagePath = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

   
    if (empty($_POST["title"])) {
        $title_err = "Title is required.";
        $isValid = false;
    } else {
        $title = htmlspecialchars($_POST["title"]);
    }

  
    if (empty($_POST["author"])) {
        $author_err = "Author name is required.";
        $isValid = false;
    } else {
        $author = htmlspecialchars($_POST["author"]);
    }

   
    if (empty($_POST["content"])) {
        $content_err = "Content is required.";
        $isValid = false;
    } elseif (strlen($_POST["content"]) < 400) {
        $content_err = "Content must be at least 400 characters.";
        $isValid = false;
    } else {
        $content = htmlspecialchars($_POST["content"]);
    }

   
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES["image"]["type"], $allowedTypes)) {
            $uploadDir = "uploads/";
            $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        } else {
            $image_err = "Only JPG, PNG, or GIF images are allowed.";
            $isValid = false;
        }
    } else {
        $image_err = "Featured image is required.";
        $isValid = false;
    }

    if ($isValid) {
        $submitted = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
  <?php include "style.css" ?>
</style>
   
    <title>Add Blog Post</title>
  

</head>
<body >
  
<?php if (!$submitted): ?>
<div class="form-box ">
    
    <h2 class="h2tag"> Blog Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <label class="lable" >Title Of The Article</label>
        <input  type="text" name="title"  value="<?php echo $title; ?>">
        <span class="error"><?php echo $title_err; ?></span>

        <label class="lable">Featured Image</label>
        <input type="file" name="image" >
        <span class="error"><?php echo $image_err; ?></span>

        <label class="lable">Author Name</label>
        <input type="text" name="author" value="<?php echo $author; ?>">
        <span class="error"><?php echo $author_err; ?></span>
        
        <label class="lable">Article Content</label>
        <textarea name="content" rows="10"><?php echo $content; ?></textarea>
        <span class="error"><?php echo $content_err; ?></span>

        <input type="submit" value="Submit Blog" >
    </form>
</div>
<?php else: ?>
<div class="post-box">
    <img src="<?php echo $imagePath; ?>" alt="Featured Image" class="post-img">

    <h2><?php echo $title; ?></h2>

    <div class="meta">
        👤 <?php echo $author; ?><br>
        📅 <?php echo date("F j, Y"); ?> | 💬 0 comments
    </div>

    

    <p><?php echo nl2br($content); ?></p>

    <p><strong>Share this post</strong> —
        <a href="#">ⓕ Facebook</a> |
        <a href="#">𝕏 Twitter</a> |
        <a href="#"> [in] LinkedIn</a>
    </p>
</div>
<?php endif; ?>

</body>
</html>
