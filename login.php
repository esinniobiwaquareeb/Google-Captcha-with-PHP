<?php 

// Form fields from index.html
$email = $_POST['email'];
$password = $_POST['password']; 
$captcha=$_POST['g-recaptcha-response'];

//check if the captcha form is filled
if(!$captcha){
  echo "<script> alert('Please Check the Captcha Field'); window.location.href='index.html';</script>";
  exit;
}

//Google captcha secret key goes here
$secretKey = "your secret key";

//Get the server ip
$ip = $_SERVER['REMOTE_ADDR'];

//through some beans to the captcha server attaching secret key, the captcha and ip
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);

//the response is in json format, use this to decode
$responseKeys = json_decode($response,true);

//Note, in the response, I only need responsekeys in the array returned

//throw some nuts to your db/server or whatever have you 
if($email == "admin@admin.com" && $password == "123456" && intval($responseKeys["success"]) == 1){
	//echo "You got it right";
	header('location:dashboard.html');
}
else{
	echo "<script> alert('Sorry, an error occured'); window.location.href='index.html';</script>";
}
?>