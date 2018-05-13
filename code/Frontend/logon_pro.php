<?php
include('config.php');
session_start();
$id = $_SESSION["user_ID"];
if(isset($_GET['decision']))
{
    $decision = $_GET['decision'];
    $from_uid = $_GET['from_uid'];
    $sql_update = "UPDATE requests SET answer=$decision WHERE to_user_ID = '$id' AND from_user_ID = '$from_uid';";
    $update_result = mysqli_query($db, $sql_update);
    //$result = mysqli_query($db, "$sql");
    $error = $db->error;
    if ($update_result == false) {
        echo "$error";
        //mysqli_query($db,"ROLLBACK");
        //echo "Rolled back";
        return false;
    }
    else
    {
        mysqli_query($db, "COMMIT;");
        echo "Committed";
    }
    header("Location: logon_pro.php");
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
    body .modal-content {
        /* new custom width */
        width: 1000px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -200px;
    }
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
      <ul class="nav navbar-nav">
          <li class="active"><a><?php
                  if (!empty($_SESSION))
                  {
                      $id = $_SESSION["user_ID"];
                      $username = $_SESSION["username"];
                      echo "User ID: $id, Username: $username";
                  }
                  ?></a></li>
      </ul>
    <ul class="nav navbar-nav navbar-right">
       <li> <a data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-bullhorn"> Notifications</span></a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h1>
        <form action="" method="post" style="text-align:center;">
            <div class=""form-group">
                <div class="col-sm-10">
                    <a href="homepage.php">
                        <img src="logo.png"
                         alt="Portakal logo"
                         style="width:271px;height:47px;border:0;" / >
                    </a>
                </div>
            </div>
        </form>
    </h1>

  <form action="" method="post" style="text-align:center;">
  <div class="btn-group btn-group-justified">
    <a name="manage" class="btn btn-warning" href="manage_pro.php" role="button">Manage Account</a>
    <a class="btn btn-warning" href="view_proposals_pro.php" role="button">View Proposals</a>
    <a class="btn btn-warning" href="view_service_requests_pro.php" role="button">View Request</a>
    <a class="btn btn-warning" href="view_services_pro.php" role="button">View Services</a>
    <a class="btn btn-warning" href="register_service.php" role="button">Service Registration</a>
  </div>
  </form>
<form action="" method="post" style="text-align:center;">
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
                        <h1>Your Notifications</h1>
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
                                    <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>Subject </th>
                                        <th>Order Type</th>
                                        <th>Price</th>
                                        <th>Accept</th>
                                        <th>Decline</th>
                                    </tr>
                               </thead>
                               <tbody>";
                            while($arr = mysqli_fetch_array($result))
                            {
                                if($arr[5] == 2)
                                {
                                    $sql2 = "SELECT email FROM users WHERE user_ID = $arr[1];";
                                    $result2 = mysqli_query($db, $sql2);
                                    $arr_2 = mysqli_fetch_array($result2);
                                    echo "<tr>";
                                    echo "<th>" . $arr_2[0] . "</th>";
                                    echo "<th>" . $arr[2] . "</th>";
                                    echo "<th>" . $arr[3] . "</th>";
                                    echo "<th>" . $arr[4] . "</th>";
                                    echo "<th> <a href=\"logon_pro.php?decision=1&from_uid=$arr[1]\" type=\"button\" class=\"btn btn-warning\">Accept</a></th>";
                                    echo "<th> <a href=\"logon_pro.php?decision=0&from_uid=$arr[1]\" type=\"button\" class=\"btn btn-warning\">Decline</a></th>";
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
