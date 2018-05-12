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
        padding:10px;
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
          <li class="active"><a><?php session_start();
                                    $id = $_SESSION["user_ID"];
                                    echo "User ID: $id";
                                    ?></a></li>
      </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
    <h1>
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
    </h1>
  <form action="" method="post" style="text-align:center;">
  <div class="btn-group btn-group-justified">
    <a name="manage" class="btn btn-warning" href="manage_pro.php" role="button">Manage Account</a>
    <a class="btn btn-warning" href="view_proposals_pro.php" role="button">View Proposals</a>
    <a class="btn btn-warning" href="view_service_requests_pro.php" role="button">View Request</a>
    <a class="btn btn-warning" href="" role="button">View Services</a>
    <a class="btn btn-warning" href="register_service.php" role="button">Service Registration</a>
  </div>
  </form>
</div>

</body>
</html>
