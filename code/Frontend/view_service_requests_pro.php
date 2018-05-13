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
        FROM regular_users rus JOIN service_orders sos WHERE rus.user_ID=sos.requester_ID 
        AND sos.service_type_ID IN (SELECT prov.service_type_ID FROM provides prov WHERE prov.user_ID = $user_ID);";
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
                $sql2 = "SELECT proposal_ID FROM proposals NATURAL JOIN proposed_services WHERE professional_ID = $user_ID AND order_ID = $row[0];";
                $result2= mysqli_query($db, $sql2);
                $row_query = mysqli_fetch_array($result2);
                $row_count = mysqli_num_rows($result2);
                if($row_count == 1)
                {
                    $sql3 = "SELECT start_date, end_date, proposed_price FROM proposed_services WHERE proposal_ID = $row_query[0];";
                    $result3 = mysqli_query($db, $sql3);
                    $inputs_arr = mysqli_fetch_array($result3);
                    echo "<th>
                        <form action=\"modify_proposal.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <a href=\"modify_proposal.php?proposal_id=$row_query[0]&start_date=$inputs_arr[0]&end_date=$inputs_arr[1]&price=$inputs_arr[2]\"type=\"button\" class=\"btn btn-warning\">Modify</a>
                                </div>
                            </div>
                        </form>
                    </th>";
                }
                else
                {
                    echo "<th>
                        <form action=\"create_proposal_pro.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <a href=\"create_proposal_pro.php?oid=$row[0]&servicetype=$row[1]\"type=\"button\" class=\"btn btn-warning\">Propose</a>
                                </div>
                            </div>
                        </form>
                    </th>";
                }
                echo "</tr>";
            }
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>
    <a href="logon_pro.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</div>
</body>
</html>