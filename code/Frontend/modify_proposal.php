<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];
if(isset($_GET['proposal_id']))
{
    $proposal_id = $_GET['proposal_id']; //service_type_id
    $originalStart = $_GET['start_date'];
    $originalEnd = $_GET['end_date'];
    $originalPrice = $_GET['price'];
    $price = 0; //default
    $start_date = "";
    $end_date = "";
    if (isset($_POST['modify']))
    {
        if(isset($_POST['start']))
            $start_date = $_POST['start'];
        if(isset($_POST['end']))
            $end_date = $_POST['end'];
        if(isset($_POST['price']))
            $price = $_POST['price'];
        $result = mysqli_query($db, "UPDATE proposed_services SET start_date='$start_date', end_date='$end_date', proposed_price = '$price' WHERE proposal_ID = '$proposal_id'");
        $error = $db->error;
        if ($result == false) {
            $error = $db->error;
            echo "$error";
            return false;
        }
        header("Location: view_proposals_pro.php");
    }
    if(isset($_POST['goback']))
    {
        header('Location: view_proposals_pro.php');
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
</style>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="homepage.php">Portakal</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Modify Proposal</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Proposal ID</th>
            <th>Starting Date</th>
            <th>Ending Date</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
                echo "<td> $proposal_id </td>";
                echo "<td> $originalStart </td>";
                echo "<td> $originalEnd </td>";
                echo "<td> $originalPrice </td>";
            ?>
        </tr>
        </tbody>
    </table>
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label for="start">Start date:</label>
            <input type="date" class="form-control" id="start" name="start" value= "<?php echo $originalStart;?>">
        </div>

        <div class="form-group">
            <label for="end">End date:</label>
            <input type="date" class="form-control" id= "end" name="end" value= "<?php echo $originalEnd;?>">
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" min="0" class="form-control" id="price" name="price" value= "<?php echo $originalPrice;?>">
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