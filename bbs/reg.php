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
	$password = trim($_POST['password']);
	$password2 = trim($_POST['password2']);
	$name = trim($_POST['name']);
	
	if (empty($password) || empty($password2) || empty($name)) {
		$wrong = 'All inputs can not be empty!';
	} else if ($password != $password2) {
		$wrong = 'Passwords are not the same!';
	} else {
		$sql = "select * from users where name='$name'";
		$query_id = mysqli_query($link, $sql);
		if ($userinfo = mysqli_fetch_assoc($query_id)) {
			$wrong = 'This username have be registered! Please change another one!';
		} else {
			$sql = "insert into users (`password`,`name`) values ('$password','$name')";
			mysqli_query($link, $sql);
			$lastID = mysqli_insert_id($link);
			$wrong = "<span class='right'>Successfully!</span>";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>register</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#regform').submit(function(){
		
		if (!this.password.value) {
			alert('Password can not be empty!');
			return false;
		}
		
		if (this.password.value != this.password2.value) {
			alert('Twice password must be the same');
			return false;
		}

		if (!this.name.value) {
			alert('Your name can not be empty!');
			return false;
		}
	});
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

	<div class="login">
    	<div class="title">
        	Register
        </div>
        
        <form method="post" id="regform">

        <div class="item">
        	<div class="sub">Username:</div>
            <div class="input"><input type="text" name="name" placeholder="Username"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password:</div>
            <div class="input"><input type="password" name="password" placeholder="Password"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password Again:</div>
            <div class="input"><input type="password" name="password2" placeholder="Password Again"></div>
        </div>
        
        <div class="item warning"><?php echo $wrong;?></div>
        
        <div class="item">
        	<button type="submit" name="submit">Register</button>
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