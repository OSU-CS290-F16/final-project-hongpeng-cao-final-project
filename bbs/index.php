<?php
include_once('conn.php');

$userinfo = array();
if (!empty($_SESSION['userid'])) {
	$sql = "select * from users where id='$_SESSION[userid]'";
	$query_id = mysqli_query($link, $sql);
	$userinfo = mysqli_fetch_assoc($query_id);
}

$sql = "select * from posts";
$query_id = mysqli_query($link, $sql);
$postArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$postArr[] = $row;
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
        		All Posts
        		<a href="create_post.php" class="floatright">Creat a new post</a>
        	</div>
            
            <div class="topics">
            	<ul>
                	<?php foreach ($postArr as $key => $value) {?>
                    	<li>
                        	<a href="post.php?id=<?php echo $value['id'];?>"><?php echo $value['title'];?></a>

                        	<span class='controls'>
                        		<a href="delete.php?id=<?php echo $value['id'];?>">delete</a>
                        		<a href="post.php?id=<?php echo $value['id'];?>">view</a>
                        	</span>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="footer">
	2016 &copy; copyright
</div>
</div>

</body>
</html>