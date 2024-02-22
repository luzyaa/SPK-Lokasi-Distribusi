<?php 

ob_start();
error_reporting(0);
session_start();
$waktu=time()+60;
$expired=2000;
if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
	if($waktu < $_SESSION['timeout']){
		unset($_SESSION['timeout']);
		$_SESSION['timeout']=$waktu+$expired;
	}
  else{
		include"logout.php";
  }

include"appConfig/conn.php";
include"appConfig/region.php";
include"appConfig/timeZone.php";
include"appConfig/libb.php";
include"_header.php";
	
?>
  <?php 
    include"content.php";
  ?>
<?php

}
  else{
	  echo"<script type='text/javascript' language='javascript'>window.alert('Maaf Untuk Masuk ke Halaman ini Anda harus Login Terlebih Dahulu');window.location=('index.php');";
	
	}
  
  include('_footer.php'); 

?>