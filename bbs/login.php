<?php


include_once('conn.php');

$userinfo = array();
if (!empty($_SESSION['userid'])) {
    $sql = "select * from users where id='$_SESSION[userid]'";
    $query_id = mysqli_query($link, $sql);
    $userinfo = mysqli_fetch_assoc($query_id);
}


if (!empty($_SESSION['userid'])) {
	header('Location: index.php');
	exit;
}

if (isset($_POST['submit'])) {
	$name = trim($_POST['name']);
	$password = trim($_POST['password']);
	
	$sql = "SELECT * from users WHERE name='" . $name ."' and password='" . $password . "'";
	$query_id = mysqli_query($link, $sql);
	if ($userinfo = mysqli_fetch_assoc($query_id)) {
		$_SESSION['userid']	= $userinfo['id'];
		header('Location: index.php');
		exit;
	} else {
		$wrong = 'Sorry. Username or Password is wrong!';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>login</title>
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

	<div class="login">
    	<div class="title">
        	Login
        </div>
        
        <form method="post">
        <div class="item">
        	<div class="sub">Username:</div>
            <div class="input"><input type="text" name="name" placeholder="Username"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password:</div>
            <div class="input"><input type="password" name="password" placeholder="Password"></div>
        </div>
        
        <div class="item warning"><?php echo $wrong;?></div>
        
        <div class="item">
        	<button type="submit" name="submit">Login</button>
        </div>
        
        </form>
    </div>
</div>

<div id="footer">
	2016 &copy; copyright
</div>
</div>

</body>
</html>