<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];
if(isset($_GET['service_id']))
{
    $service_id = $_GET['service_id']; //service_type_id
    $original_service_name = $_GET['service_name'];
    $originalStart = $_GET['start_date'];
    $originalEnd = $_GET['end_date'];
    $start_date = "";
    $end_date = "";
    $name = "";
    if(isset($_POST['modify']))
    {
        if(isset($_POST['custom_name']))
            $name = $_POST['custom_name'];
        if(isset($_POST['start']))
            $start_date = $_POST['start'];
        if(isset($_POST['end']))
            $end_date = $_POST['end'];
        $sql_query1 = "UPDATE provided_services 
                       SET custom_service_name = '$name', service_starting_date = '$start_date', service_ending_date = '$end_date'
                       WHERE custom_service_name = '$original_service_name' AND service_type_ID = '$service_id';";
        $sql_query2 = "UPDATE provides SET custom_service_name = '$name' WHERE user_ID = '$user_ID' AND service_type_ID = '$service_id' AND custom_service_name = '$original_service_name';";

        $result1 = mysqli_query($db, $sql_query1);
        $result2 = mysqli_query($db, $sql_query2);

        $result = $result1 && $result2;
        $error = $db->error;
        if ($result == false) {
            echo "$error";
            mysqli_query($db,"ROLLBACK");
            echo "Rolled back";
            return false;
        }
        else
        {
            mysqli_query($db, "COMMIT;");
            echo "Committed";
        }
        header("Location: view_services_pro.php");
    }
    if(isset($_POST['goback']))
    {
        header('Location: view_services_pro.php');
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
        <div class="navbar-header">
            <a class="navbar-brand" href="homepage.php">Portakal</a>
        </div>
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
            <label for="end">Planned End Date:</label>
            <input type="date" value="<?php echo $originalEnd;?>" class="form-control" name="end">
        </div>
        <div class="form-group">
            <label for="odetails">Custom Service Name:</label>
            <textarea class="form-control" rows="5" name="custom_name"><?php echo $original_service_name;?></textarea>
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