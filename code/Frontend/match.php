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

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="homepage.php">Portakal</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="homepage.php">Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Page 1-1</a></li>
                    <li><a href="#">Page 1-2</a></li>
                    <li><a href="#">Page 1-3</a></li>
                </ul>
            </li>
            <li><a href="#">Page 2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Service Proposals</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Type</th>
            <th>Order Details</th>
            <th>Starting Date</th>
            <th>Ending Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include('config.php');
        session_start();
        $user_ID = $_SESSION['user_ID'];
        if(isset($_GET['order_id']))
        {
            $order_id = $_GET['order_id'];
            $sql = "SELECT sos.order_ID, sos.service_type_ID, sos.order_details, sos.start_date, sos.end_date FROM service_orders sos WHERE sos.requester_ID=$user_ID AND sos.order_ID = $order_id; ";
            $result = mysqli_query($db, "$sql");
            while($row = mysqli_fetch_array($result)) {
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
                    echo "<th>" . $row[3] . "</th>";
                    echo "<th>" . $row[4] . "</th>";
                }
        }
        ?>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Proposal ID</th>
            <th>Starting Date</th>
            <th>Ending Date</th>
            <th>Price</th>
            <th>Add</th>
            <th>Remove</th>
        </tr>
        </thead>
        <tbody>
        <!--BURALARA PHP SERPİŞTİRİLECEK-->
        <?php
            $sql_temp_create = "CREATE TEMPORARY TABLE temp_proposal (
                  proposal_ID INT PRIMARY KEY,
                  p_start DATE,
                  p_end DATE,
                  proposed_price INT
            );";
            $sql_date_table = "CREATE TEMPORARY TABLE temp_date (
                      proposal_ID INT PRIMARY KEY,
                      proposed_price INT,
                      p_start DATE,
                      p_end DATE,
                      start_date DATE,
                      end_date DATE 
            );";

            $sql_temp = "INSERT INTO temp_proposal(proposal_ID, p_start, p_end, proposed_price) 
                         SELECT proposal_ID, start_date AS p_start, end_date AS p_end, proposed_price FROM proposed_services WHERE order_ID = $order_id;";

            $sql_date_fill = "INSERT INTO temp_date(proposal_ID, proposed_price, p_start, p_end, start_date, end_date)
                              SELECT proposal_ID, proposed_price, p_start, p_end, start_date, end_date
                              FROM temp_proposal NATURAL JOIN service_orders so
                              WHERE so.order_ID = $order_id;";

            $sql_date_diff= "SELECT proposal_ID, proposed_price, p_start, p_end, DATEDIFF(p_start, p_end) AS prop_time, DATEDIFF(start_date, end_date) AS serv_time, 
                             DATEDIFF(p_start, start_date) AS starts, DATEDIFF(p_end, end_date) AS ends 
                             FROM temp_date
                             HAVING ABS(prop_time) < ABS(serv_time) OR (ABS(ends) < 3 AND ABS(starts) < 3 );";

            $result1 = mysqli_query($db, $sql_temp_create);
            $result2 = mysqli_query($db, $sql_date_table);
            $result3 = mysqli_query($db, $sql_temp);
            $result4 = mysqli_query($db, $sql_date_fill);
            $result5 = mysqli_query($db, $sql_date_diff);
            $result_temp = $result5;
            $result = $result1 && $result2 && $result3 && $result4 && $result5;
            $error = $db->error;
            if ($result == false) {
                echo "$error";
                return false;
            }

            while($row = mysqli_fetch_array($result_temp)) {
                    echo "<tr>";
                    echo "<th>" . $row[0] . "</th>";
                    echo "<th>" . $row[1] . "</th>";
                    echo "<th>" . $row[2] . "</th>";
                    echo "<th>" . $row[3] . "</th>";
                    echo "<td>
                    <form action=\"\" method=\"post\">
                                        <div class=\"form-group\">
                                            <div class=\"col-sm-offset-0 col-sm-0\">
                                                <button type=\"submit\" name=\"add\" class=\"btn btn-warning\">Add</button>
                                            </div>
                                        </div>
                                    </form>
                    </td>";
                    echo "<td>
                                    <form action=\"\" method=\"post\">
                                        <div class=\"form-group\">
                                            <div class=\"col-sm-offset-0 col-sm-0\">
                                                <button type=\"submit\" name=\"remove\" class=\"btn btn-danger\">Remove</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>";
                echo "<td>
                                    <form action=\"accept_proposal.php\" method=\"post\">
                                        <div class=\"form-group\">
                                            <div class=\"col-sm-offset-0 col-sm-0\">
                                                <button type=\"submit\" name=\"remove\" class=\"btn btn-danger\">Accept</button>
                                                <input type=\"hidden\" name='proposalid' value='$row[0]'></input>
                                                <input type=\"hidden\" name='orderid' value='$order_id'></input>
                                            </div>
                                        </div>
                                    </form>
                                </td>";
                echo "</tr>";
                    echo "</tr>";
                //}
            }
            $sql_drop_temp_proposal = "DROP TEMPORARY TABLE temp_proposal;";
            $sql_drop_temp_date = "DROP TEMPORARY TABLE temp_date;";

             $drop1 = mysqli_query($db, $sql_drop_temp_proposal);
             $drop2 = mysqli_query($db, $sql_drop_temp_date);
             $drop = $drop1 && $drop2;

             $error = $db->error;
            if ($drop == false) {
                echo "$error";
                return false;
            }
        ?>
        <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tbody>
    </table>
</div>
<a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</body>
</html>