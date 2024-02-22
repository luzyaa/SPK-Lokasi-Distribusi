<?php
include "appConfig/conn.php";
// function antiinjection($data){
//   $filter_sql = mysqli_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
//   return $filter_sql;
// }

$username 	= $_POST['txtUsername'];
// $email		= $_POST['txtUsername'];
$pass     	= (md5($_POST['txtPassword']));

$waktu = time()+25200;
$expired=60;

$query=mysqli_query($conn,"SELECT * FROM tpengguna WHERE username='$username' AND password='$pass'");
$in=mysqli_num_rows($query);
$r=mysqli_fetch_array($query);

if ($in > 0){
  session_start();
  
  $_SESSION['kdPengguna']      	= $r['kdPengguna'];
  $_SESSION['username']    		  = $r['username'];
  $_SESSION['password']      	  = $r['password'];
  $_SESSION['nmLengkap']  		  = $r['nmLengkap'];
    
	  
  $_SESSION['timeout']		= $waktu+$expired;
  $waktulog= time();												
										
  header('location:frame.php?loadPage=dashboard');
}
else{
    echo "<script type='text/javascript'>window.alert('Username atau password salah,tolong cek kembali');window.location =('index.php')</script>";
}
?>
