<?php


/*this this database link file*/

session_start();
error_reporting(E_ALL^E_NOTICE);


$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'caoho-db';
$dbuser = 'caoho-db';
$dbpass = 'ALuBwmRpSdzl6hzT';


/*
$dbhost = 'localhost';
$dbname = '111bbs';
$dbuser = 'root';
$dbpass = '';
*/

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// error output the notice
if (!$link) {
	die('failed to connect the database');
}

?>