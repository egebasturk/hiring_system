<?php
session_start();
include ('config.php');
?>
<html lang="en">
<head>
  <title>Portakal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
      <ul class="nav navbar-nav">
          <li class="active"><a><?php
            if(!empty($_SESSION["user_ID"])) {
                $id = $_SESSION["user_ID"];
                $username = $_SESSION["username"];
                echo "User ID: $id, Username: $username";
            }
            else{
                echo "Currently not logged in!";
            }
                  ?></a></li>

      </ul>
    <ul class="nav navbar-nav navbar-right">
        <?php
                if(empty($_SESSION["user_ID"])) {
                    echo "<li><a href=\"signup_reg.php\"><span class=\"glyphicon glyphicon-user\"></span> Sign Up</a></li>";
                    echo "<li><a href=\"login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
                }
                else{
                    echo "<li><a href=\"login.php\"><span class=\"glyphicon glyphicon-log-out\"></span> Logout</a></li>";
                    $sql = "SELECT user_ID
                            FROM users us NATURAL JOIN regular_users rus
                            WHERE rus.user_ID='$id'";
                    if (mysqli_num_rows(mysqli_query($db, "$sql")) == 1)
                        echo "<li><a href=\"logon_reg.php\"><span class=\"glyphicon glyphicon-home\"></span> My Home</a></li>";
                    else
                        echo "<li><a href=\"logon_pro.php\"><span class=\"glyphicon glyphicon-home\"></span> My Home</a></li>";
                }
      ?>

    </ul>
  </div>
</nav>
<div class="container">
    <h1>
        <a href="homepage.php">
            <img src="logo.png"
                 alt="Portakal logo"
                 style="width:271px;height:47px;border:0;">
        </a>
    </h1>
<div class="form-group">
    <button type="button" class="btn btn-danger btn-xs">Repair</button>
    <button type="button" class="btn btn-primary btn-xs">Cleaning</button>
    <button type="button" class="btn btn-success btn-xs">Painting</button>
    <button type="button" class="btn btn-info btn-xs">Moving</button>
    <button type="button" class="btn btn-warning btn-xs">Private Lesson</button>
</div>

<div class="form-group row">
    <div class="col-xs-2">
        <label for="ex1">Min price:</label>
        <input class="form-control" id="ex1" type="number" min="0">
    </div>
    <div class="col-xs-2">
        <label for="ex1">Max price:</label>
        <input class="form-control" id="ex2" type="number" min="0">
    </div>
    <div class="col-xs-2">
        <label for="ex1">Start date:</label>
        <input class="form-control" id="ex3" type="date">
    </div>
    <div class="col-xs-2">
        <label for="ex1">End date:</label>
        <input class="form-control" id="ex4" type="date">
    </div>
    <div class="col-xs-2">
        <label for="ex1">Min rating:</label>
        <input class="form-control" id="ex5" type="number" min="0">
    </div>
</div>
<form action="" method = "post">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search">
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </div>
    </div>
</form>

</div>
</body>
</html>
<?php
   $method_value = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
   if($method_value== 'POST')
   {
      $server_service_type = $_POST['service_type'];
      $results = array();
      $result_query = "";
      $lower_service_type = strtolower($server_service_type);
      $service_ID = '';
      if($lower_service_type == "repair")
          $service_ID = 1;
      if($lower_service_type == "cleaning")
          $service_ID = 2;
       if($lower_service_type == "painting")
           $service_ID = 3;
       if($lower_service_type == "moving")
           $service_ID = 4;
       if($lower_service_type == "private_lesson" || $lower_service_type == "private lesson" || $lower_service_type == "private lesson")
           $service_ID = 5;
       $result_query = mysqli_query($db, "SELECT * FROM provided_services WHERE service_type_ID='$service_ID'");
       echo "<div class=\"container\"> 
             <table style=\"background-color:#181818; color:#FFF\" class=\"table\">
             <thead class=\"thead-dark\"> 
             <tr> <th>Name </th>
                  <th>Service Rating </th>
                  <th>Starting Date </th>
             </tr>
             </thead>
             <tbody>";
       while($row = mysqli_fetch_array($result_query)) {
           echo "<tr> 
                <td> $row[1] </td>
                <td> $row[2] </td>
                <td> $row[3] </td>
                </tr>";
       }
       echo "</tbody>
                </table> </div>";

      /*

      if($lower_service_type == "repair")
      {
           $result_query = mysqli_query($db, "SELECT service_type_ID, custom_service_name, base_material_price, item_type FROM repair_service");
           echo "<div align = 'center'> <h2> SERVICES </h2> <table border = '1'> ";
           echo "<th>ID</th><th>name</th><th>base material price</th><th>material type </th><br>";
           while($row = mysqli_fetch_array($result_query))
           {
              $results[] = $row;
              echo "<tr>";
              echo "<td align = 'center'> $row[0] </td>    ";
              echo "<td align = 'center'> $row[1] </td>    ";
              echo "<td align = 'center'> $row[2] </td>    ";
              echo "<td align = 'center'> $row[3] </td>    ";
              echo "</tr>";
              echo "<br>";
          }
        echo "</table> </div>";
      }
      elseif($lower_service_type == "cleaning")
      {
           $result_query = mysqli_query($db, "SELECT service_type_ID, custom_service_name, base_room_price, base_bathroom_price, worker_rate, frequency FROM cleaning_service");
           echo "<div align = 'center'> <h2> SERVICES </h2> <table border = '1'> ";
           echo "<th>ID</th><th>name</th><th>base room price</th><th>base bathroom price </th><th>worker rate</th> <th>frequency</th><br>";
           while($row = mysqli_fetch_array($result_query))
           {
              $results[] = $row;
              echo "<tr>";
              echo "<td align = 'center'> $row[0] </td>    ";
              echo "<td align = 'center'> $row[1] </td>    ";
              echo "<td align = 'center'> $row[2] </td>    ";
              echo "<td align = 'center'> $row[3] </td>    ";
              echo "<td align = 'center'> $row[4] </td>    ";
              echo "<td align = 'center'> $row[5] </td>    ";
              echo "</tr>";
              echo "<br>";
          }
          echo "</table> </div>";
      }
      elseif($lower_service_type == "painting")
      {
          $result_query = mysqli_query($db, "SELECT service_type_ID, custom_service_name, total_volume, color_type FROM painting_service");
          echo "<div align = 'center'> <h2> SERVICES </h2> <table border = '1'> ";
          echo "<th>ID</th><th>name</th><th>total volume</th><th>color type</th><th>number of rooms</th><br>";
          while($row = mysqli_fetch_array($result_query))
          {
              $results[] = $row;
              echo "<tr>";
              echo "<td align = 'center'> $row[0] </td>    ";
              echo "<td align = 'center'> $row[1] </td>    ";
              echo "<td align = 'center'> $row[2] </td>    ";
              echo "<td align = 'center'> $row[3] </td>    ";
              echo "</tr>";
              echo "<br>";
          }
          echo "</table> </div>";
      }
      elseif($lower_service_type == "moving")
      {
          $result_query = mysqli_query($db, "SELECT service_type_ID, custom_service_name, city_name, new_city_name FROM moving_service");
          echo "<div align = 'center'> <h2> SERVICES </h2> <table border = '1'> ";
          echo "<th>ID</th><th>name</th><th>total volume</th><th>color type</th><th>number of rooms</th><br>";
          while($row = mysqli_fetch_array($result_query))
          {
              $results[] = $row;
              echo "<tr>";
              echo "<td align = 'center'> $row[0] </td>    ";
              echo "<td align = 'center'> $row[1] </td>    ";
              echo "<td align = 'center'> $row[2] </td>    ";
              echo "<td align = 'center'> $row[3] </td>    ";
              echo "</tr>";
              echo "<br>";
          }
          echo "</table> </div>";
      }
      */
    }

?>