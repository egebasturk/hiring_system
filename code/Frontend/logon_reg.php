<?php
    include('config.php');
    session_start();
    $error = ""; // Default value
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
        color: #ef863d;
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
        <ul class="nav navbar-nav navbar-right">
            <li> <a data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-bullhorn"></span> Notifications</a></li>
            <li>
                <a href="manage_reg.php"><span class="glyphicon glyphicon-user"></span><?php
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
    <h1>
        <form action="" method="post" style="text-align:left;">
            <div class=""form-group">
            <div class="col-sm-10">
                <a href="homepage.php">
                    <img src="logo.png"
                         alt="Portakal logo"
                         style="width:271px;height:47px;border:0;" / >
                </a>
            </div>
</div>
<br><br>
</h1>
<div class="container">
  <div class="btn-group btn-group-vertical" style="width: 80%; height: 200%;">
      <br>
    <a href="manage_reg.php" class="btn btn-warning">Manage Account</a>
      <br>
    <a href="view_service_requests_reg.php" class="btn btn-warning">Service Requests</a>
      <br>
    <a href="view_proposals_reg.php?order_id=0" class="btn btn-warning">View Proposals</a>
      <br>
    <a href="past_services.php" class="btn btn-warning">View Past Services</a>
  </div>
</div>
<form action="" method="post" style="text-align:center;">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Notifications</h4>
                </div>
                <div class="modal-body">
                    <div id="section3" class="container-fluid">
                        <?php
                        $id = $_SESSION["user_ID"];
                        $sql = "SELECT * FROM requests WHERE to_user_ID = $id;";
                        $result = mysqli_query($db, $sql);
                        $error = $db->error;
                        if ($result == false) {
                            echo "$error";
                            return false;
                        }
                        echo "<table class=\"table table-bordered\">
                            
                               <tbody>";
                        while($arr = mysqli_fetch_array($result))
                        {
                            if($arr[5] == 2)
                            {
                                $sql2 = "SELECT email FROM users WHERE user_ID = $arr[1];";
                                $result2 = mysqli_query($db, $sql2);
                                $arr_2 = mysqli_fetch_array($result2);
                                echo "<tr>";
                                echo "<th>" . $arr_2[0] . " sent you a proposal!</th>";
                                echo "</tr>";
                            }
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

</body>
</html>