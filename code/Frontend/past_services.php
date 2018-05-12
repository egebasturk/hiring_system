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
    <h1>Past Services</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Experience</th>
            <th>Expertise Field</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Evaluate</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
            <?php
                include('config.php');
                $error = '';
                session_start();
                $user_ID = $_SESSION['user_ID'];
                $results = array();
                $result_query = mysqli_query($db, "SELECT provider_ID FROM regular_users NATURAL JOIN has_taken WHERE user_ID = $user_ID");
                while($row = mysqli_fetch_array($result_query))
                {
                    $provider_query = mysqli_query($db, "SELECT email, city_name, experience, expertise_field FROM professional_users NATURAL JOIN users WHERE user_ID = $row[0]");
                    $rating_query = mysqli_query($db, "SELECT rating, evaluation FROM service_ratings_evaluations WHERE user_ID = $user_ID AND provider_ID = $row[0]");
                    $email = "";
                    $city = "";
                    $exp = "";
                    $expertise = "";
                    $rating = "";
                    $eval = "";
                    echo "<tr>";
                    while($print_row = mysqli_fetch_array($provider_query))
                    {
                        $email = $print_row[0];
                        $city = $print_row[1];
                        $exp = $print_row[2];
                        $expertise = $print_row[3];
                        echo "<td>$print_row[0]</td>";
                            echo "<td>$print_row[1]</td>";
                            echo "<td>$print_row[2]</td>";
                            echo "<td>$print_row[3]</td>";
                    }
                    while($rating_print = mysqli_fetch_array($rating_query))
                    {
                        $rating = $rating_print[0];
                        $eval = $rating_print[1];
                        echo "<td>$rating_print[0]</td>";
                        echo "<td>$rating_print[1]</td>";
                    }
                    echo "<td> bu ne ak? </td>";
                    echo "<td>";
                    echo "<form action=\"evaluate_service.php?email=$email&city=$city&exp=$exp&expertise=$expertise&rating=$rating&eval=$eval&provider=$row[0]\" method=\"post\">";
                        echo"<div class=\"form-group\">";
                            echo "<div class=\"col-sm-offset-0 col-sm-0\">";
                                echo"<button type=\"submit\"name=\"submit\" class=\"btn btn-warning\">Edit</button>";
                            echo "</div>";
                        echo "</div>";
                    echo "</form>";
                    echo"</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<a href="logon_reg.php" type="button" class="btn btn-warning">Go Back To Home Page</a>
</body>
</html>