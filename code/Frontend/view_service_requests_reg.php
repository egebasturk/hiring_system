<?php
    include('config.php');
    session_start();
    $error = "";
    //global $user_ID;
    $user_ID= $_SESSION["user_ID"];

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
    if(isset($_POST['select']))
    {
        $target  = 'Location: view_proposals_reg.php?order_id=';
        $target .= $_POST['select'];
        header($target);
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
                        <form action=\"\" method=\"post\">
                           <div class=\"radio-group\">
                            <button style='height: 25px;width: 25px' type=\"submit\" name=\"select\" value=\"$row[0]\">
                          </div>
                        </form>
                      </th>";
                echo "<th>" . $row[0] . "</th>";
                if($row[1] == 1)
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
                                    <input type=\"hidden\" name='var' value='$row[0]'></input>
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
        </div>
    </div>


</body>
</html>

