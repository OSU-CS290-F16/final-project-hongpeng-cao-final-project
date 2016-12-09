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

$sql = "delete from comments where postid='$postid'";
mysqli_query($link, $sql);

$sql = "delete from posts where id='$postid'";
mysqli_query($link, $sql);

header('location: index.php');
exit;


?>