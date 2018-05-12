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
    body {background-color: rgb(255, 165, 0);}
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
      <li><a href="signup_reg.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
<div class="container">
  <h1>Welcome</h1>
  <span class="label label-danger">Repair</span>
  <span class="label label-primary">Cleaning</span>
  <span class="label label-success">Painting</span>
  <span class="label label-info">Moving</span>
  <span class="label label-warning">Private Lesson</span>
  <br/> <br/>
  <form  action="" method = "post">
      <div class="form-group">
        <input type="text" name = "service_type" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body>
</html>
<?php
   include ('config.php');
   $method_value = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
   if($method_value== 'POST')
   {
      $server_service_type = $_POST['service_type'];
      $results = array();
      $result_query = "";
      $lower_service_type = strtolower($server_service_type);
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
    }
?>