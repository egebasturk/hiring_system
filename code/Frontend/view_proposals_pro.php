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
    $sql = "DELETE FROM proposed_services 
            WHERE proposed_services.proposal_ID=$oid";
    $result = mysqli_query($db, "$sql");
    $error = $db->error;
    if ($result == false) {
        $error = $db->error;
        echo "$error";
        return false;
    }
    //header("Location: view_service_requests_reg.php");
}
else
    echo "";//DEBUG



$sql = "SELECT proposal_ID, start_date, end_date, proposed_price
FROM (professional_users pros NATURAL JOIN proposals ps) NATURAL JOIN proposed_services pservs
WHERE pros.user_ID=$user_ID";
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
    <h1>View Proposals</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Proposal ID</th>
            <th>Starting Date</th>
            <th>Ending Date</th>
            <th>Price</th>
            <th>Modify</th>
            <th>Cancel</th>
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
                echo "<th>" . $row[3] . "</th>";
                echo "<th>
                        <form action=\"modify_service_request.php\" method=\"post\">
                            <div class=\"form-group\">
                                <div class=\"col-sm-offset-0 col-sm-0\">
                                    <a href=\"modify_proposal.php?proposal_id=$row[0]&start_date=$row[1]&end_date=$row[2]&price=$row[3]\"type=\"button\" class=\"btn btn-warning\">Modify</a>
                                </div>
                            </div>
                        </form>
                    </th>
                    <th>
                        <form action=\"view_proposals_pro.php\" method=\"post\">
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
    <a href="logon_pro.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</div>
</body>
</html>