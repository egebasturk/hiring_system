<?php
include('config.php');
session_start();
$error = "";
//global $user_ID;
$user_ID= $_SESSION["user_ID"];


$sql = "SELECT provs.service_type_ID, provs.custom_service_name, provs.service_starting_date, provs.service_ending_date, provs.service_rating
        FROM provided_services provs JOIN provides ps JOIN professional_users profs
        WHERE profs.user_ID = '$user_ID' AND provs.custom_service_name=ps.custom_service_name AND profs.user_ID=ps.user_ID";
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
    $servicetype = $_POST['servicetype'];
    $servicename = $_POST['servicename'];

    $sql = "DELETE
            FROM `provided_services`
            WHERE `provided_services`.`service_type_ID` = '$servicetype' AND `provided_services`.`custom_service_name` = '$servicename'";
    $result = mysqli_query($db, "$sql");
    $error = $db->error;
    if ($result == false) {
        $error = $db->error;
        echo "$error";
        return false;
    }
    header("Location: view_services_pro.php");
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
<body>
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
    <h1>Registered Services</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Service Type ID</th>
            <th>Custom Service Name</th>
            <th>Active Starting Date</th>
            <th>Active Ending Date</th>
            <th>Rating</th>
            <th>Modify</th>
            <th>Cancel</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <?php
            if ($result != false)
            {
                while($row = mysqli_fetch_array($result))
                {
                    echo "<tr>";
                    echo "<th>" . $row[0] . "</th>";
                    echo "<th>" . $row[1] . "</th>";
                    echo "<th>" . $row[2] . "</th>";
                    echo "<th>" . $row[3] . "</th>";
                    echo "<th>" . $row[4] . "</th>";
                    echo "<th>
                        <form action=\"#\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <a href=\"modify_registered_service.php?service_id=$row[0]&service_name=$row[1]&start_date=$row[2]&end_date=$row[3]\"type=\"button\" class=\"btn btn-warning\">Modify</a>
                                </div>
                            </div>
                        </form>
                    </th>";
                    echo "<th>
                        <form action=\"view_services_pro.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <button type=\"submit\" class=\"btn btn-warning\" name='cancel' value='Cancel'>Cancel</button>
                                    <input type=\"hidden\" name='servicetype' value='$row[0]'></input>
                                    <input type=\"hidden\" name='servicename' value='$row[1]'></input>
                                    
                                </div>
                            </div>
                        </form>
                    </th>";
                    echo "</tr>";
                }
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