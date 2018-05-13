<?php
    include('config.php');
    session_start();
    $error = ""; // Default value
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
</style>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="active"><a><?php
                    if(!empty($_SESSION["user_ID"])) {
                        $id = $_SESSION["user_ID"];
                        $username = $_SESSION["username"];
                        echo "User ID: $id, Username: $username";
                    }
                    else{
                        echo "Currently not logged in!";
                    }
                    ?></a></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="manage_reg.php"><span class="glyphicon glyphicon-user"></span><?php
                    if (!empty($_SESSION))
                    {
                        $username = $_SESSION["username"];
                        $id = $_SESSION["user_ID"];
                        echo " $username";
                    }
                    ?>
                </a>
            </li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>
  
<div class="container">
    <h1>
        <form action="" method="post" style="text-align:left;">
            <div class=""form-group">
            <div class="col-sm-0">
                <a href="homepage.php">
                    <img src="logo.png"
                         alt="Portakal logo"
                         style="width:271px;height:47px;border:0;">
                </a>
            </div>
</div>
</h1>
  <div class="btn-group btn-group-justified">
    <a href="manage_reg.php" class="btn btn-warning">Manage Account</a>
    <a href="view_service_requests_reg.php" class="btn btn-warning">Service Requests</a>
    <a href="view_proposals_reg.php?order_id=0" class="btn btn-warning">View Proposals</a>
    <a href="past_services.php" class="btn btn-warning">View Past Services</a>
  </div>
</div>

</body>
</html>