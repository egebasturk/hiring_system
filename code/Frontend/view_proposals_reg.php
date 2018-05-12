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
                if($order_id == 0) //entered the page from logon menu, view all services
                {
                    $sql = "SELECT sos.order_ID, sos.service_type_ID, sos.order_details, sos.start_date, sos.end_date
                            FROM regular_users rus JOIN service_orders sos
                            WHERE rus.user_ID=$user_ID AND sos.requester_ID=$user_ID;";
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
                        echo "</tr>";
                    }
                }
                else //accessed from view service requests menu, view only this service.
                {
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
                        echo "</tr>";

                    }
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
                if($order_id == 0)
                {
                    $sql = "SELECT ps.proposal_ID, ps.start_date, ps.end_date, ps.proposed_price FROM proposed_services ps NATURAL JOIN (SELECT order_ID FROM service_orders WHERE requester_ID = $user_ID) os;";
                    $result = mysqli_query($db, $sql);
                    $error = $db->error;
                    if ($result == false) {
                        echo "$error";
                        return false;
                    }

                    while($row = mysqli_fetch_array($result)) {
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
                        echo "</tr>";
                    }
                }
                else
                {
                    $sql = "SELECT proposal_ID, start_date, end_date, proposed_price FROM proposed_services WHERE order_ID = $order_id;";
                    $result = mysqli_query($db, $sql);
                    $error = $db->error;
                    if ($result == false) {
                        echo "$error";
                        return false;
                    }

                    while($row = mysqli_fetch_array($result)) {
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
                        echo "</tr>";

                    }
                }
            ?>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>
</div>
<a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</body>
</html>