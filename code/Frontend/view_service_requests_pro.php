<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];

if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}



$sql = "SELECT sos.order_ID, sos.service_type_ID, sos.order_details
FROM regular_users rus JOIN service_orders sos;";
$result = mysqli_query($db, "$sql");
$error = $db->error;
if ($result == false) {
    $error = $db->error;
    echo "$error";
    return false;
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
    <h1>Service Requests</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Type</th>
            <th>Order Details</th>
            <th>Proposals</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<th>" . $row[0] . "</th>";
                echo "<th>" . $row[1] . "</th>";
                echo "<th>" . $row[2] . "</th>";
                echo "<th>
                        <form action=\"create_proposal_pro.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <button type=\"submit\" class=\"btn btn-warning\" name='propose' value='Propose'>Propose</button>
                                    <input type=\"hidden\" name='oid' value='$row[0]'></input>
                                    <input type=\"hidden\" name='servicetype' value='$row[1]'></input>
                                </div>
                            </div>
                        </form>
                    </th>";
                echo "</tr>";
            }
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>
</div>
<a href="logon_pro.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</body>
</html>