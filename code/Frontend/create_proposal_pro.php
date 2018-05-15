<?php
include('config.php');
session_start();
$error = "";
$req_error = "";
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
            return false;
        }
        else
        {
            mysqli_query($db, "COMMIT;");
        }
        header("Location: view_proposals_pro.php?from_id=1");
    }
    if(isset($_POST['invite']))
    {
        if(isset($_POST['request_price']))
        {
            $servicetype = $_SESSION['servicetype'];
            $oid = $_SESSION['oid'];
            $req_price = $_POST['request_price'];
            $req_start = $_POST['request_start'];
            $req_end = $_POST['request_end'];
            if($_POST['request_price'] == 0)
                $query_price = "not determined";
            else
                $query_price = $_POST['request_price'];
            $to_user_ID = $_POST['invite'];
            $sql = "INSERT INTO requests(to_user_ID, from_user_ID, subject, order_ID, price, answer, start_date, end_date)
                VALUES('$to_user_ID', '$user_ID', 'Collaboration Invitation', '$oid', '$query_price', '2', '$req_start', '$req_end');";
            $result1 = mysqli_query($db, $sql);
        }
    }
    if(isset($_POST['accept']))
    {
        if(isset($_POST['accepted_price']))
        {
            $servicetype = $_SESSION['servicetype'];
            $oid = $_SESSION['oid'];
            $to_user_ID = $_POST['accept'];
            $accepted_price = $_POST['accepted_price'];
            $servicetype = $_SESSION['servicetype'];
            $start_date = $_POST['accepted_start'];
            $end_date = $_POST['accepted_end'];
            mysqli_query($db, "START TRANSACTION;");
            $sql_query1 = "INSERT INTO proposed_services (service_type_ID, start_date, end_date, proposed_price, order_ID)
                            VALUES ( '$servicetype', '$start_date', '$end_date', '$accepted_price', '$oid');";
            $sql_query2 = "SELECT LAST_INSERT_ID() as autoInc INTO @autoInc;";
            $sql_query3 = "INSERT INTO proposals (professional_ID, proposal_ID) VALUES('$user_ID', @autoInc);";
            $sql_query4 = "INSERT INTO collaborators(proposal_ID, user_one_ID, user_two_ID) VALUES (@autoInc, '$user_ID', '$to_user_ID');";
            $result1 = mysqli_query($db, $sql_query1);
            $result2 = mysqli_query($db, $sql_query2);
            $result3 = mysqli_query($db, $sql_query3);
            $result4 = mysqli_query($db, $sql_query4);
            $result = $result1 && $result2 && $result3 && $result4;
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
        }
        header("Location: view_proposals_pro.php?from_id=1");
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
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="homepage.php">Portakal</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="manage_pro.php"><span class="glyphicon glyphicon-user"></span><?php
                    if (!empty($_SESSION))
                    {
                        $username = $_SESSION["username"];
                        $id = $_SESSION["user_ID"];
                        echo " $username";
                    }
                    else
                    {
                        echo " Currently not logged in!";
                    }
                    ?>
                </a>
            </li>
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
            if ($row[1] == 1)
                echo "<th>Repair</th>";
            elseif ($row[1] == 2)
                echo "<th>Cleaning</th>";
            elseif ($row[1] == 3)
                echo "<th>Painting</th>";
            elseif ($row[1] == 4)
                echo "<th>Moving</th>";
            elseif ($row[1] == 5)
                echo "<th>Private Lesson</th>";
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
        <div class="modal fade" id="myModal" role="dialog" ">
        <div class="modal-dialog" style="padding-right: 1000px">
            <!-- Modal content-->
            <div class="modal-content" style="width: 1200px" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invite Professionals</h4>
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
                                        <th>Price</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Invite</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                        while($help = mysqli_fetch_array($result_help))
                        {
                            $sql_pending = "SELECT answer, price, start_date, end_date FROM requests WHERE to_user_ID = '$help[0]' AND from_user_ID = '$user_ID' AND order_ID = '$oid';";
                            $result_pending = mysqli_query($db, $sql_pending);
                            $pending = mysqli_fetch_array($result_pending);
                            $row_count = mysqli_num_rows($result_pending);
                            echo "<tr>";
                            echo "<th>" . $help[1] . "</th>";
                            echo "<th>" . $help[2] . "</th>";
                            if($row_count == 0)
                            {
                                echo "<th> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"request_price\"></th>";
                                echo "<th> <input type=\"date\" class=\"form-control\" name=\"request_start\"></th>";
                                echo "<th> <input type=\"date\" class=\"form-control\" name=\"request_end\"></th>";
                                echo "<th><button type=\"submit\" name=\"invite\" class=\"btn btn-warning\" value=\"$help[0]\">Invite</button></th>";
                            }
                            else
                            {
                                if($pending[0] == 2)
                                {
                                    echo " <th> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"pending_price\" value=\"$pending[1]\" readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\" name=\"request_start\" value=\"$pending[2]\" readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\" name=\"request_end\" value=\"$pending[3]\" readonly></th>";
                                    echo "<th><button type=\"submit\" name=\"pending\" class=\"btn btn-warning\" value=\"$help[0]\">Pending</button></th>";
                                }
                                elseif($pending[0] == 1)
                                {
                                    echo " <th> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"accepted_price\" value=\"$pending[1]\" readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\" name=\"accepted_start\" value=\"$pending[2]\" readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\" name=\"accepted_end\" value=\"$pending[3]\" readonly></th>";
                                    echo "<th><button type=\"submit\" name=\"accept\" class=\"btn btn-warning\" value=\"$help[0]\">Accepted!</button></th>";
                                }
                                elseif($pending[0] == 0)
                                {
                                    echo " <th> <input type=\"number\" min=\"0\" class=\"form-control\" value=\"$pending[1]\" readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\"readonly></th>";
                                    echo "<th> <input type=\"date\" class=\"form-control\"readonly></th>";
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