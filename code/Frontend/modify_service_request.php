<?php
    include('config.php');
    session_start();
    $error = "";
    //global $user_ID;
    $user_ID= $_SESSION["user_ID"];
    if(isset($_GET['order_id']))
    {
        $orderID = $_GET['order_id']; //service_type_id
        $originalOrderDetails = $_GET['order_details'];
        $originalServiceType = $_GET['order_type'];
        $originalStart = $_GET['start_date'];
        $originalEnd = $_GET['end_date'];
        echo $orderID;
        $serviceType = 1; //default
        $orderDetails = ""; //default
        $start_date = "";
        $end_date = "";
        if (isset($_POST['modify']))
        {
            if(isset($_POST['radio']))
                $serviceType = $_POST['radio'];
            if(isset($_POST['odetails']))
                $orderDetails = $_POST['odetails'];
            if(isset($_POST['start']))
                $start_date = $_POST['start'];
            if(isset($_POST['end']))
                $end_date = $_POST['end'];
            echo "$serviceType";
            $result = mysqli_query($db, "UPDATE service_orders SET service_type_ID='$serviceType', order_details='$orderDetails', start_date='$start_date', end_date='$end_date' WHERE order_ID = $orderID AND requester_ID ='$user_ID'");
            $error = $db->error;
            if ($result == false) {
                $error = $db->error;
                echo "$error";
                return false;
            }
            header("Location: view_service_requests_reg.php");
        }
        if(isset($_POST['goback']))
        {
            header('Location: view_service_requests_reg.php');
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
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <h1>Modify Request</h1>
            <label for="start">Start date:</label>
            <input type="date" value= "<?php echo $originalStart;?>" class="form-control" name="start">
        </div>

        <div class="form-group">
            <label for="end">End date:</label>
            <input type="date" value="<?php echo $originalEnd;?>" class="form-control" name="end">
        </div>

        <div class="form-group">
            <label for="service">Service Type:</label>
            <div class="radio-group">
                <label class="radio-inline">
                    <input type="radio" name="radio" value="1" <?php
                     if($originalServiceType == 1)
                         echo "checked=\"checked\"";
                      ?>>Repair
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio" value="2"<?php
                    if($originalServiceType == 2)
                        echo "checked=\"checked\"";
                    ?>>Cleaning
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio" value="3"<?php
                    if($originalServiceType == 3)
                        echo "checked=\"checked\"";
                    ?>>Painting
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio" value="4"<?php
                    if($originalServiceType == 4)
                        echo "checked=\"checked\"";
                    ?>>Moving
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio" value="5"<?php
                    if($originalServiceType == 5)
                        echo "checked=\"checked\"";
                    ?>>Private Lesson
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="odetails">Order Details:</label>
            <textarea class="form-control" rows="5" name="odetails"><?php echo $originalOrderDetails;?></textarea>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-0">
                <button type="submit" class="btn btn-warning" name="modify">Modify</button>
                <button type="submit" class="btn btn-warning" name="goback">Cancel</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>