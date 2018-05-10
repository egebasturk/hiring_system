<?php
if(isset($_POST['submit'])){
	if(empty($_POST['username']) || empty($_POST['password'])){
		$error = "Fields can't be left blank";
	}
	else{
		$username=$_POST['username'];
		$password=$_POST['password'];
		
	$conn = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr", "bugra.aydin", "5okn15mlz");
	$db = mysqli_select_db($conn, "bugra_aydin");
	
	
	$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$username' AND password='$password'");
	$rows = mysqli_num_rows($query);
	if($rows == 1){
		//session_start(); KEYI BI SONRAKI SAYFAYA AKTARMA OLAYI
		//$_SESSION
		header("Location: homepage.php");
	}
	else{
		$error = "No user was found";
	}
	mysqli_close($conn);
	}
}
?>




<!DOCTYPE html>
<html lang="en">


<head>
  <title>Portakal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>
	body {background-color: rgb(200, 120, 0);}
	input[class=form-control]{
	width:100%;
	background-color:#253;
	color:#fff;
	border:2px solid #06F;
	padding:10px;
	font-size:20px;
	cursor:pointer;
	border-radius:5px;
	margin-bottom:15px; 
}
</style>

<body>
<form action="" method="post" style="text-align:center;">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="homepage.php">Home Page</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="signup_reg.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h1>Portakal</h1>
  <form action="" method="post" style="text-align:center;">
  <form class="form-horizontal" action="/action_page.php">
    <div class="form-group">
      <div class="col-sm-10">
        <input type="text" class="form-control" id="username" placeholder="Username/E-mail" name="username">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
      </div>
    </div>
	<div class="form-group">
		<div class="col-sm-10">
			<span><?php echo $error; ?></span>
		</div>
	</div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
