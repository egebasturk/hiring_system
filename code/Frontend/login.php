<?php
    include('config.php');
    $error = ""; // Default value
    session_start();
    if (session_id())
    {
        // session has been started
        session_destroy();
    }
    if(isset($_POST['submit']))
    {
        if (empty($_POST['username']) || empty($_POST['password']))
        {
            $error = "Fields can't be left blank";
        }
        else
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = mysqli_query($db, "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'");
            $rows = mysqli_num_rows($query);
            if($rows == 1)
            {
                //session_start(); KEYI BI SONRAKI SAYFAYA AKTARMA OLAYI
                //$_SESSION
                $user = mysqli_fetch_object($query);
                $id = $user->user_ID;
                $username = $user->username;
                $query = mysqli_query($db, "SELECT user_ID FROM professional_users WHERE user_ID='$id'");
                $isProf = mysqli_num_rows($query);
                session_start();
                $_SESSION['user_ID'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['is_prof'] = $isProf;
                if($isProf == 1){
                    header("Location: logon_pro.php");
                }
                else{
                    header("Location: logon_reg.php");
                }
            }
            else{
                $error = "No user was found";
            }
            mysqli_close($db);
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
    input[type=text]:focus {
        border: 3px solid #555;
    }
    input[type=password]:focus {
        border: 3px solid #555;
    }
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
    input[class=btn btn-default]{
        width:100%;
        background-color:#FFF;
        color:#000;
        border:2px solid #FFF;
        font-size:20px;
        cursor:pointer;
        border-radius:5px;
        margin-bottom:15px;
    }
</style>


<body>
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="signup_reg.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    </ul>
  </div>
</nav>
<form action="" method="post"">
<div class="container">
    <form action="" method="post" style="text-align:center;">
  <div class=""form-group">
        <div class="col-sm-10">
        <a href="homepage.php">
            <img src="logo.png"
                 alt="Portakal logo"
                 style="width:271px;height:47px;border:0;">
        </a>

        </div>
    </div>

    <div class="form-group">
      <div class="col-sm-10">
          <br>
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
      <div class="col-sm-offset-0 col-sm-10">
        <button type="submit" name="submit" class="btn btn-warning">Login</button>
      </div>
    </div>
</div>
</form>

</body>
</html>
