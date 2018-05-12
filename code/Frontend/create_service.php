<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];

if (isset($_POST['create']))
{
    //echo "sth"; DEBUG
    $serviceType = 1; // Bunu bir şekilde radio buttonlardan almak gerek
    $orderDetails = "";
    $start_date = "";
    $end_date = "";
    if(isset($_POST['radio']))
        $serviceType = $_POST['radio'];
    if(isset($_POST['odetails']))
        $orderDetails = $_POST['odetails'];
    if(isset($_POST['start']))
        $start_date = $_POST['start'];
    if(isset($_POST['end']))
        $end_date = $_POST['end'];
    $sql = "INSERT INTO service_orders (requester_ID, service_type_ID, order_details, start_date, end_date)
	VALUES ('$user_ID','$serviceType', '$orderDetails', '$start_date', '$end_date');";
    $result = mysqli_query($db, "$sql");
    $error = $db->error;
    if ($result == false) {
        $error = $db->error;
        echo "$error";
        return false;
    }
    header("Location: view_service_requests_reg.php");
}
else
    echo "no";
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
    <form class="form-horizontal" action="create_service.php" method="POST">
        <div class="form-group">
            <h1>Create Request</h1>
            <label for="start">Start date:</label>
            <input type="date" class="form-control" name="start">
      </div>   

      <div class="form-group">
        <label for="end">End date:</label>
        <input type="date" class="form-control" name="end">
      </div>  

      <div class="form-group">
      <label for="service">Service Type:</label>
        <div class="radio-group">
          <label class="radio-inline">
            <input type="radio" name="radio" value="1">Repair
          </label>
          <label class="radio-inline">
            <input type="radio" name="radio" value="2">Cleaning
          </label>
          <label class="radio-inline">
            <input type="radio" name="radio" value="3">Painting
          </label>
          <label class="radio-inline">
            <input type="radio" name="radio" value="4">Moving
          </label> 
          <label class="radio-inline">
            <input type="radio" name="radio" value="5">Private Lesson
          </label>          
        </div>
      </div>
        <div class="form-group">
            <label for="odetails">Order Details:</label>
            <textarea class="form-control" rows="5" name="odetails"></textarea>
        </div>

        <div class="form-group">
        <div class="col-sm-offset-0 col-sm-0">
          <button type="submit" class="btn btn-warning" name="create">Create</button>
            <a href="view_service_requests_reg.php" type="button" class="btn btn-warning">Back</a>
        </div>
      </div>
  </form>
  </div>

</body>
</html>