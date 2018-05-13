<?php
include('config.php');
session_start();
$error = "";
$oid = "";
$servicetype = "";
$user_ID= $_SESSION["user_ID"];
if(isset($_GET['servicetype']))
{
    $_SESSION['servicetype'] = $_GET['servicetype'];
    $_SESSION['oid'] = $_GET['oid'];
    $servicetype = $_SESSION['servicetype'];
    $oid = $_SESSION['oid'];
    if (isset($_POST['create']))
    {
        $servicetype = $_SESSION['servicetype'];
        $oid = $_SESSION['oid'];
        if(isset($_POST['price']))
            $price = $_POST['price'];
        if(isset($_POST['start']))
            $start_date = $_POST['start'];
        if(isset($_POST['end']))
            $end_date = $_POST['end'];
        mysqli_query($db, "START TRANSACTION;");
        $sql_query1 = "INSERT INTO proposed_services (service_type_ID, start_date, end_date, proposed_price, order_ID)
                            VALUES ( '$servicetype', '$start_date', '$end_date', '$price', '$oid');";
        $sql_query2 = "SELECT LAST_INSERT_ID() as autoInc INTO @autoInc;";
        $sql_query3 = "INSERT INTO proposals (professional_ID, proposal_ID) VALUES ('$user_ID', @autoInc);";


        $result1 = mysqli_query($db, $sql_query1);
        $result2 = mysqli_query($db, $sql_query2);
        $result3 = mysqli_query($db, $sql_query3);
        $result = $result1 && $result2 && $result3;

        //$result = mysqli_query($db, "$sql");
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
        header("Location: view_proposals_pro.php");
    }
    if(isset($_POST['invite']))
    {
        $servicetype = $_SESSION['servicetype'];
        $oid = $_SESSION['oid'];
        $to_user_ID = $_POST['invite'];
        $sql = "INSERT INTO requests(to_user_ID, from_user_ID, subject, order_ID, price, answer)
                VALUES('$to_user_ID', '$user_ID', 'Collaboration Invitation', '$oid', '0', '2');";
        $result1 = mysqli_query($db, $sql);
        echo "invitation sent";
    }
    if(isset($_POST['accept']))
    {

    }

}


/* Insert query
 * INSERT INTO `proposed_services` (`service_type_ID`, `start_date`, `end_date`, `proposed_price`) VALUES ( '1', '2018-05-01', '2018-05-23', '100');
SELECT LAST_INSERT_ID() as autoInc INTO @autoInc;
INSERT INTO `proposals` (`professional_ID`, `proposal_ID`) VALUES ('2', @autoInc);
 * */
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
    #section3 {padding-top:50px;height:500px;color: #fff; background-color: #ff9800;}

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
    <h1>Service Request</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Type</th>
            <th>Order Details</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            $servicetype = $_SESSION['servicetype'];
            $oid = $_SESSION['oid'];
            $sql = "SELECT sos.order_ID, sos.service_type_ID, sos.order_details
                    FROM service_orders sos
                    WHERE sos.order_ID ='$oid';";
            $result = mysqli_query($db, "$sql");
            $error = $db->error;
            if ($result == false) {
                $error = $db->error;
                echo "$error";
                return false;
            }
            $row = mysqli_fetch_array($result);
            echo "<tr>";
            echo "<th>" . $row[0] . "</th>";
            echo "<th>" . $row[1] . "</th>";
            echo "<th>" . $row[2] . "</th>";
            echo "</tr>";
            //<button type="submit" class="btn btn-warning" name="help" value="help">Get Help</button>
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>

    <form class="form-horizontal" action="create_proposal_pro.php?oid=<?php echo "$oid&servicetype=$servicetype";?>"method="POST">
        <div class="form-group">
            <label for="start">Start date:</label>
            <input type="date" class="form-control" name="start">
        </div>

        <div class="form-group">
            <label for="end">End date:</label>
            <input type="date" class="form-control" name="end">
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" min="0" class="form-control" name="price">
        </div>

        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-0">
                <button type="submit" class="btn btn-warning" name="create" value="Create">Create Proposal</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Get Help</button>
                <a href="view_service_requests_pro.php" type="button" class="btn btn-warning">Go Back</a>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <div id="section3" class="container-fluid">
                            <h1>Find other professionals who can help you</h1>
                            <?php
                            $servicetype = $_SESSION['servicetype'];
                            $oid = $_SESSION['oid'];
                                $sql_city = "SELECT city_name FROM users WHERE user_ID = $user_ID;";
                                $result_city = mysqli_query($db, $sql_city);
                                $city = mysqli_fetch_array($result_city);
                                $sql_help = "SELECT user_ID, custom_service_name, email
                                             FROM provides p NATURAL JOIN users u
                                             WHERE u.city_name = '$city[0]' AND p.service_type_ID = $servicetype AND u.user_ID != $user_ID;";
                                $result_help = mysqli_query($db, $sql_help);
                                $error = $db->error;
                                if ($result_help == false) {
                                    echo "$error";
                                    return false;
                                }
                                echo "<table class=\"table table-bordered\">
                                    <thead>
                                    <tr>
                                        <th>Custom Service Name</th>
                                        <th>User</th>
                                        <th>Invite</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                                while($help = mysqli_fetch_array($result_help))
                                {
                                    $sql_pending = "SELECT answer FROM requests WHERE to_user_ID = '$help[0]' AND from_user_ID = '$user_ID' AND order_ID = '$oid';";
                                    $result_pending = mysqli_query($db, $sql_pending);
                                    $pending = mysqli_fetch_array($result_pending);
                                    $row_count = mysqli_num_rows($result_pending);
                                    echo "<tr>";
                                    echo "<th>" . $help[1] . "</th>";
                                    echo "<th>" . $help[2] . "</th>";
                                    if($row_count == 0)
                                    {
                                        echo "<th><button type=\"submit\" name=\"invite\" class=\"btn btn-warning\" value=\"$help[0]\">invite</button></th>";
                                    }
                                    else
                                    {
                                        if($pending[0] == 2)
                                        {
                                            echo "<th><button type=\"submit\" name=\"pending\" class=\"btn btn-warning\" value=\"$help[0]\">pending</button></th>";
                                        }
                                        elseif($pending[0] == 1)
                                        {
                                            echo "<th><button type=\"submit\" name=\"accept\" class=\"btn btn-warning\" value=\"$help[0]\">Accepted!</button></th>";
                                        }
                                        elseif($pending[0] == 0)
                                        {
                                            echo "<th><button type=\"submit\" name=\"declined\" class=\"btn btn-warning\" disabled>Declined</button></th>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<script>

</script>
</body>
</html>