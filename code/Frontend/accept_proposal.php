<?php
include('config.php');
session_start();
$user_ID = $_SESSION['user_ID'];
if(isset($_POST['proposalid']))
{
    $proposalid = $_POST['proposalid'];
    //echo "$proposalid";
}
if(isset($_POST['orderid']))
{
    $orderid = $_POST['orderid'];
    //echo "$orderid";
}
// TODO: Fix this.
$sql_update = "INSERT INTO past_services (service_type_ID, order_date, provider_ID)
                SELECT service_type_ID, pservs.start_date, ps.professional_ID
                        FROM proposed_services pservs NATURAL JOIN proposals ps
                        WHERE proposal_ID='$proposalid'";


$result = mysqli_query($db, "$sql_update");

$error = $db->error;
if ($result == false) {
    $error = $db->error;
    echo "$error";
    return false;
}
$sql_update = "INSERT INTO has_taken (user_ID, service_type_ID, order_date, provider_ID)
                SELECT '$user_ID', service_type_ID, pservs.start_date, ps.professional_ID
                        FROM proposed_services pservs NATURAL JOIN proposals ps
                        WHERE proposal_ID='$proposalid'";
$result = mysqli_query($db, "$sql_update");
$error = $db->error;
if ($result == false) {
    $error = $db->error;
    echo "$error";
    return false;
}
?>
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
    <h1>Accepted Proposal</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Type</th>
            <th>Starting Date</th>
            <th>Ending Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            $sql = "SELECT order_ID, service_type_name, sos.start_date, sos.end_date
                    FROM services s NATURAL JOIN service_orders sos
                    WHERE sos.order_ID='$orderid'";
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
            echo "<th>" . $row[1]. "</th>";
            echo "<th>" . $row[2] . "</th>";
            echo "<th>" . $row[3] . "</th>";
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>

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
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            $sql = "SELECT pservs.proposal_ID, pservs.start_date, pservs.end_date, pservs.proposed_price
                    FROM proposed_services pservs NATURAL JOIN proposals ps
                    WHERE pservs.proposal_ID='$proposalid';";
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
            echo "<th>" . $row[1]. "</th>";
            echo "<th>" . $row[2] . "</th>";
            echo "<th>" . $row[3] . "</th>";

            $sql_email = "SELECT us.email
                            FROM (proposed_services pservs NATURAL JOIN proposals ps) JOIN (professional_users profs NATURAL JOIN users us)
                            WHERE pservs.proposal_ID='$proposalid' AND profs.user_ID=ps.professional_ID";
            $to = mysqli_fetch_array(mysqli_query($db, $sql_email))[0]; // send and get email.
            //echo "$to";
            $subject = "Your proposal with id $proposalid was accepted";


            /*$sql_customer_email = "SELECT rus.name, us.email
                                    FROM service_orders sos NATURAL JOIN regular_users rus NATURAL JOIN users us
                                    WHERE sos.order_ID='1'";
            $customer_email = mysqli_fetch_array(mysqli_query($db, $sql_customer_email))[1];
            $customer_name = mysqli_fetch_array(mysqli_query($db, $sql_customer_email))[0];
            $text = "$customer_name has accepted your proposal. You can contact his/her email: $customer_email";
            $headers ="From: noreply@portakal.com" . "\r\n";
            mail($to, $subject, $text, $headers);
            echo "A mail has been sent to the proposer. You will be contacted by your registered email."
            */
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>
    <h1>Related Services</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Experience</th>
            <th>Expertise Field</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Evaluation</th>
        </tr>
        </thead>
        <tbody>
        <tr>

        </tr>
        </tbody>
    </table>
    <a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</div>
</body>
</html>