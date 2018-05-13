<?php
    include('config.php');
	$error = '';
	if(isset($_POST['submit'])){
		session_start();
		$id = $_SESSION['user_ID'];	
		if(empty($_POST['username']) ||
								empty($_POST['password']) ||
								empty($_POST['mail']) ||
								empty($_POST['name']) ||
								empty($_POST['surname']) ||
								empty($_POST['dob']) ||
								empty($_POST['city']) ||
								empty($_POST['street']) ||
								empty($_POST['apt']) ||  
								empty($_POST['zip']))
			{
				$error = "Fields can't be left blank!";
			} 
		
		else{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$mail = $_POST['mail'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$dob = $_POST['dob'];
				$city = $_POST['city'];
				$street = $_POST['street'];
				$apt = $_POST['apt'];
				$zip = $_POST['zip'];

				if($db->connect_error){
					die("Connection failed: " . $db->connect_error);
				}
				
				$sql = "UPDATE users SET username='$username', password='$password', email='$mail', city_name=$city, street_number='$street', apt_name='$apt', zip_code='$zip_code' WHERE user_ID='$id'";
				if($db->query($sql) === TRUE){
					$error = "Record updated succesfully";
					$sql = "UPDATE regular_users SET name='$name', surname='$surname', date_of_birth='$dob' WHERE user_ID='$id'";
					if($db->query($sql) === TRUE){
						$error = "done";
						header('Location: logon_reg.php');
					}
					else{
						$error = "Error update: " . $sql . "<br> . $db->error";
					}
				}
				else{
					$error = "Error update: " . $sql . "<br> . $db->error";
				}
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
    body {background-color: rgb(256, 256, 256);}
    input[class=form-control]{
        width:100%;
        background-color:#FFF;
        color:#000;
        border:2px solid #FFF;
        font-size:20px;
        cursor:pointer;
        border-radius:5px;
        margin-bottom:15px;
    }
    input[class=form-control]:focus {
        border: 3px solid #555;
    }
</style>
<body>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="homepage.php">Portakal</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="homepage.php">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>


<div class="container">
  <h1>Manage account</h1>
    <form action="" method="post">
    <div class="form-group">
      <label for="usr">Username:</label>
      <input type="text" class="form-control" id="usr" name="username">
    </div>

    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
      <label for="mail">E-mail:</label>
      <input type="email" class="form-control" id="mail" name="mail">
    </div>  

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>  

    <div class="form-group">
      <label for="surname">Surname:</label>
      <input type="text" class="form-control" id="surname" name="surname">
    </div>   

    <div class="form-group">
      <label for="dob">Date of birth:</label>
      <input type="date" class="form-control" id="dob" name="dob">
    </div>   

    <div class="form-group">
      <label for="city">City:</label>
      <input type="text" class="form-control" id="city" name="city">
    </div>   

    <div class="form-group">
      <label for="street">Street no:</label>
      <input type="text" min="0" class="form-control" id="street" name="street">
    </div>  

    <div class="form-group">
      <label for="apt">Apartment name:</label>
      <input type="text" class="form-control" id="apt" name="apt">
    </div>  

    <div class="form-group">
      <label for="zip">Zip code:</label>
      <input type="text" min="0" class="form-control" id="zip" name="zip">
    </div>   
    <div class="form-group">        
      <div class="col-sm-offset-0 col-sm-0">
        <a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
        <button type="submit" name="submit" class="btn btn-warning">Update</button>
      </div>
    </div>
  </form>
  </div>
</body>
</html>
