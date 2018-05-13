<?php
    include('config.php');
	$error = '';
	if(isset($_POST['submit'])){
		session_start();
		$id = $_SESSION['user_ID'];	
		if(empty($_POST['username']) ||
								empty($_POST['password']) ||
								empty($_POST['mail']) ||
								empty($_POST['city']) ||
								empty($_POST['street']) ||
								empty($_POST['apt']) ||  
								empty($_POST['zip']) ||
								empty($_POST['exp']) ||
								empty($_POST['radio']))
			{
				$error = "Fields can't be left blank!";
			} 
		
		else{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$mail = $_POST['mail'];
				$city = $_POST['city'];
				$street = $_POST['street'];
				$apt = $_POST['apt'];
				$zip = $_POST['zip'];
				$exp = $_POST['exp'];
				$radio = $_POST['radio'];

				if($db->connect_error){
					die("Connection failed: " . $db->connect_error);
				}
				
				$sql = "UPDATE users SET username='$username', password='$password', email='$mail', city_name='city', street_number='$street', apt_name='$apt', zip_code='$zip' WHERE user_ID='$id'";
				if($db->query($sql) === TRUE){
					$error = "Record updated succesfully";
					$sql = "UPDATE professional_users SET experience='$exp', expertise_field='$radio' WHERE user_ID='$id'";
					if($db->query($sql) === TRUE){
						$error = "done";
						header('Location: logon_pro.php');
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
	  <form action="" method="post" style="text-align:left;">
      <div class="form-group">
        <h1>Manage account</h1>
        <label for="usr">Username:</label>
        <input type="text" class="form-control" id="usr" name="username">
      </div>

      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" name="password">
      </div>

      <div class="form-group">
        <label for="mail">E-mail:</label>
        <input type="email" class="form-control" id="mail" name="mail">
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
        <label for="exp">Experience</label>
        <input type="number" min="0" class="form-control" id="exp" name="exp">
      </div>  

      <div class="form-group">
      <label for="service">Service Type:</label>
        <div class="radio-group">
          <label class="radio-inline">
            <input type="radio" value="repair" name="radio">Repair
          </label>
          <label class="radio-inline">
            <input type="radio" value="cleaning" name="radio">Cleaning
          </label>
          <label class="radio-inline">
            <input type="radio" value="painting" name="radio">Painting
          </label>
          <label class="radio-inline">
            <input type="radio" value="moving" name="radio">Moving
          </label> 
          <label class="radio-inline">
            <input type="radio" value="private_lesson" name="radio">Private Lesson
          </label>          
        </div>
      </div>

      <div class="form-group">        
        <div class="col-sm-offset-0 col-sm-0">
          <button type="submit" name="submit" class="btn btn-warning">Update</button>
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
