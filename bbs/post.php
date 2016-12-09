<?php
include_once('conn.php');

$userinfo = array();
if (!empty($_SESSION['userid'])) {
	$sql = "select * from users where id='$_SESSION[userid]'";
	$query_id = mysqli_query($link, $sql);
	$userinfo = mysqli_fetch_assoc($query_id);
}

if (isset($_GET['id'])) {
	$postid = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (isset($_POST['newcomment'])) {
	$comment_content = trim($_POST['comment_content']);
	
	if (empty($userinfo)) {
		$wrong = 'you should login first';
	} else if (empty($comment_content)) {
		$wrong = 'comment can not be empty';
	} else {
		$time = time();
		$sql = "insert into comments (`userid`,`postid`,`time`,`content`) values ('$_SESSION[userid]','$postid','$time','$comment_content')";
		mysqli_query($link, $sql);
	}
}

$sql = "select posts.img,posts.title,posts.content,users.name from posts left join users on users.id=posts.userID where posts.id='$postid'";
$query_id = mysqli_query($link, $sql);
$postinfo = mysqli_fetch_assoc($query_id);

$sql = "select users.name,comments.content from comments left join users on users.id=comments.userid where postid='$postid'";
$query_id = mysqli_query($link, $sql);
$commentArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$commentArr[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>bbs</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){

})
</script>
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
                	<?php echo $postinfo['title'];?>
                </span>
            </div>
            
            <div class="topics">
                <div class="posttitle">Title: <?php echo $postinfo['title'];?></div>
                <div class="postauthor">Author: <?php echo $postinfo['name'];?></div>
                <div class="content">Content: <?php echo $postinfo['content'];?></div>
                <div class="postimg"><img src="<?php echo $postinfo['img'];?>" alt=""></div>
            </div>
            
            <div class="comment">
            	<div class="commenttitle">Comments:</div>
                
                <?php foreach ($commentArr as $key => $value) {?>
                <div class="subcomment">
                	<div class="name">name: <span><?php echo $value['name'];?></span></div>
                    <div class="comment_content">say: <?php echo $value['content'];?></div>
                </div>
                <?php }?>
            </div>
        </div>
        
        <div class="home2">
        	<form method="post">
        	<div class="title">New Comment:</div>
            <div>
            	<textarea name="comment_content"></textarea>
            </div>
            
            <button type="submit" name="newcomment">Create New Comment</button>
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