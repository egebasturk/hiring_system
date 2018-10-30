<?php

    include('config.php');
	$error = '';
	if(isset($_POST['submit'])){
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['mail']) || empty($_POST['name']) ||
								empty($_POST['surname']) || empty($_POST['dob']) || empty($_POST['city']) ||
								empty($_POST['street']) || empty($_POST['apt']) ||  empty($_POST['zip']))
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
			$error = "$username,$password,$mail,$name,$surname,$dob,$city,$street,$apt,$zip";
			

			if($db->connect_error){
				die("Connection failed: " . $db->connect_error);
			}
			
			$sql = "INSERT IGNORE INTO users (password, email, username, city_name, street_number, apt_name, zip_code) VALUES('$password', '$mail', '$username', '$city', '$street', '$apt', '$zip')";
			if($db->query($sql) === TRUE){
				$error = "Record created succesfully";
			}
			else{
				$error = "Error during sign up: " . $sql . "<br> . $db->error";
			}
			$sql = "INSERT IGNORE INTO regular_users(user_ID, name, surname, date_of_birth) VALUES(LAST_INSERT_ID(), '$name', '$surname', '$dob')";
			if($db->query($sql) === TRUE){
				$error = "done";
			}
			else{
				$error = "Error during sign up: " . $sql . "<br> . $db->error";
			}
			
			/*
			$userID = mysqli_query("SELECT 'AUTO_INCREMENT' FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = bugra_aydin AND TABLE_NAME = users");
			$query = mysqli_query($db, "INSERT IGNORE INTO regular_users(user_ID, name, surname, date_of_birth)
											VALUES('$userID', '$name', '$surname', '$dob')");
			*/
			$db->close();
		}
	}
	if(isset($_POST['pro'])){
		header('Location: signup_pro.php'); 
	}
	if(isset($_POST['reg'])){
		header('Location: signup_reg.php'); 
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
<body>


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>
                <a href="homepage.php">
                    <img src="logo.png"
                         alt="Portakal logo"
                         style="width:271px;height:47px;border:0;">
                </a>

    </h1>
    <form action="" method="post" style="text-align:left;">
    <div class="btn-group btn-group-justified">
      <div class="btn-group">
        <button type="submit" name="pro" class="btn btn-warning">Professional User</button>
      </div>
      <div class="btn-group">
        <button type="submit" name="reg" class="btn btn-warning">Regular User</button>
      </div>       
    </div>
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
      <input type="number" min="0" class="form-control" id="street" name="street">
    </div>  

    <div class="form-group">
      <label for="apt">Apartment name:</label>
      <input type="text" class="form-control" id="apt" name="apt">
    </div>  

    <div class="form-group">
      <label for="zip">Zip code:</label>
      <input type="number" min="0" class="form-control" id="zip" name="zip">
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-0 col-sm-0">
        <button type="submit" name="submit" class="btn btn-warning">Submit</button>
      </div>
    </div>
        <div class="form-group">
            <div class="col-sm-10">
                <span><?php echo $error; ?></span>
            </div>
        </div>
  </form>
  </div>
</body>
</html>
