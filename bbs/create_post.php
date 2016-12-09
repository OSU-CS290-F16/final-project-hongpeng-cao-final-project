<?php
include_once('conn.php');

$userinfo = array();
if (!empty($_SESSION['userid'])) {
    $sql = "select * from users where id='$_SESSION[userid]'";
    $query_id = mysqli_query($link, $sql);
    $userinfo = mysqli_fetch_assoc($query_id);
}

function get_extension($file) {
    return '.'.substr(strrchr($file, '.'), 1);
}

if (isset($_POST['newpost'])) {
	$post_name = trim($_POST['post_name']);
	$post_content = trim($_POST['post_content']);
	
    if (empty($userinfo)) {
        $wrong = 'you should login first';
    } else if (empty($post_name)) {
		$wrong = 'Post Title can not be empty';
	} else if (empty($post_content)) {
		$wrong = 'Post Content can not be empty';
	} else if ($_FILES["post_img"]["error"] > 0) {
        $wrong = "image upload error";
    } else if ($_FILES["post_img"]["type"] != "image/gif" && $_FILES["post_img"]["type"] != "image/jpeg" && $_FILES["post_img"]["type"] != "image/pjpeg" && $_FILES["post_img"]["type"] != "image/png") {
        $wrong = "only gif,jpg,png is supported";
    } else if ($_FILES["post_img"]["size"] > 400000) {
        $wrong = "the max size of image is 400k";
    } else {
        
        $time = time();
        $sql = "insert into posts (`userID`,`title`,`content`,`time`,`img`) values ('$_SESSION[userid]','$post_name','$post_content','$time','')";
        mysqli_query($link,$sql);
        $lastID = mysqli_insert_id($link);
        
        $imgFile = "upload/".$lastID;
        $imgFile = $imgFile . get_extension($_FILES["post_img"]["name"]);
        
        if (file_exists($imgFile)){
            unlink($imgFile);
            move_uploaded_file($_FILES["post_img"]["tmp_name"],$imgFile);
        } else {
            move_uploaded_file($_FILES["post_img"]["tmp_name"],$imgFile);
        }
        
        $sql = "update posts set img='$imgFile' where id='$lastID'";
        mysqli_query($link,$sql);
        
        $wrong = "<span class='right'>添加成功<span>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>bbs</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
</head>
<body>

<div id="wrapper">

<div id="header">
	<?php if (empty($_SESSION['userid'])) {?>
        <a href="index.php">Home</a>
        <span class="split">|</span>
    	<a href="reg.php">Register</a>
    	<span class="split">|</span>
    	<a href="login.php">Login</a>
    <?php } else {?>
        <a href="index.php">Home</a>
        <span class="split">|</span>
    	<span>Welcome: <a href="#"><?php echo $userinfo['name'];?></a></span>
    	<span class="split">|</span>
    	<a href="logout.php">Logout</a>
    <?php }?>
</div>

<div id="content">
	<div class="main">
    	<div class="home">
            <div class="title">
                <span class="now">
                    <a href="index.php">Home</a>
                    /
                    Create a new post
                </span>
            </div>
        </div>
        
        <div class="home2">
        	<form method="post" enctype="multipart/form-data">
        	<div class="title">New Post Title:</div>
            <div>
            	<input type="text" name="post_name">
            </div>

            <div class="title">Post image:</div>
            <div>
                <input type="file" name="post_img">
            </div>
            
            <div class="title">New Post Content:</div>
            <div>
            	<textarea name="post_content"></textarea>
            </div>
            
            <button type="submit" name="newpost">Create New Post</button>
            <span class="warning"><?php echo $wrong;?></span>
            </form>
        </div>
    </div>
</div>

<div id="footer">
	2016 &copy; copyright
</div>
</div>

</body>
</html>