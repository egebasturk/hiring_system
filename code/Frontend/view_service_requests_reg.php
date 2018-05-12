<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];

if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['cancel']))
{
    //echo "sth";DEBUG
    $oid = $_POST['var'];
    echo $oid; // Can take this but cannot delete
    $sql = "DELETE FROM `service_orders` WHERE `service_orders`.`order_ID` = '$oid'";
    $result = mysqli_query($db, "$sql");
    $error = $db->error;
    if ($result == false) {
        $error = $db->error;
        echo "$error";
        return false;
    }
    //header("Location: view_service_requests_reg.php");
}
$selected_order_id = 0;
if(isset($_POST['radio']))
{
    $selected_order_id = $_POST['radio'];
    if(isset($_POST['proposal']))
    {
        if($selected_order_id == 0)
            echo "select a service";
        else
            header('Location: view_proposals_reg.php');
    }
    else
        echo "anan";
}



$sql = "SELECT sos.order_ID, sos.service_type_ID, sos.order_details, sos.start_date, sos.end_date
FROM regular_users rus JOIN service_orders sos
WHERE rus.user_ID=$user_ID AND sos.requester_ID=$user_ID;";
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

<div class="container">
    <h1>Service Requests</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Select </th>
            <th>Order ID</th>
            <th>Order Type</th>
            <th>Order Details</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Modify Request</th>
            <th>Cancel Request</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            $counter = 0;
            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<th>            
                        <input type=\"radio\" name=\"radio\" value=$row[0]>
                     </th>";
                echo "<th>" . $row[0] . "</th>";
                echo "<th>" . $row[1] . "</th>";
                echo "<th>" . $row[2] . "</th>";
                echo "<th>" . $row[3] . "</th>";
                echo "<th>" . $row[4] . "</th>";
                echo "<th>
                        <form action=\"modify_service_request.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <a href=\"modify_service_request.php?order_id=$row[0]&order_type=$row[1]&order_details=$row[2]&start_date=$row[3]&end_date=$row[4]\" type=\"button\" class=\"btn btn-warning\">Modify</a>
                                </div>
                            </div>
                        </form>
                    </th>
                    <th>
                        <form action=\"view_service_requests_reg.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <button type=\"submit\" class=\"btn btn-warning\" name='cancel' value='Cancel'>Cancel</button>
                                    <input type=\"hidden\" name='var' value='$row[0]'>Cancel</input>
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
    <div class="form-group">
        <div class="col-sm-offset-0 col-sm-0">
            <a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
            <a href="create_service.php" type="button" class="btn btn-warning">Create Service Request</a>
            <button type="submit" class="btn btn-warning" name="proposal" method="post">View Proposal of Selected Service</button>
        </div>
    </div>
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <button type="submit" class="btn btn-warning" name="proposal">View Proposals of Selected Service</button>
        </div>
    </form>

</body>
</html>

