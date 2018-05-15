<?php
session_start();
include ('config.php');
?>
<html lang="en">
<head>
  <title>Portakal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <form action="" method="post">
    <div class="form-group">
        <label for="service">Service Type:</label>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-rounded active btn-md form-check-label">
                <input type="radio" value="1" autocomplete="off" name="service_type">Repair <i class="fa fa-cogs"></i>
            </label>
            <label class="btn btn-rounded active btn-md form-check-label">
                <input type="radio" value="2" autocomplete="off" name="service_type">Cleaning <i class="fa fa-leaf"></i>
            </label>
            <label class="btn btn-rounded active btn-md form-check-label">
                <input type="radio" value="3" autocomplete="off" name="service_type">Painting <i class="fa fa-paint-brush"></i>
            </label>
            <label class="btn btn-rounded active btn-md form-check-label">
                <input type="radio" value="4" autocomplete="off" name="service_type">Moving <i class="fa fa-home"></i>
            </label>
            <label class="btn btn-rounded active btn-md form-check-label">
                <input type="radio" value="5" autocomplete="off" name="service_type">Private Lesson <i class="fa fa-graduation-cap"></i>
            </label>
        </div>
    </div>


<div class="form-group row">
    <div class="col-xs-2">
        <label for="ex1">Min Rating:</label>
        <input class="form-control" id="ex1" name="min_rating" type="number" min="0">
    </div>
    <div class="col-xs-2">
        <label for="ex1">Desired Time Range</label>
        <input class="form-control" id="ex3" name="start_date" type="date">
    </div>
    <div class="col-xs-2">
        <label style="color:#FFF;" for="ex1">End date:</label>
        <input class="form-control" id="ex4" name="end_date" type="date">
    </div>
    <div class="col-xs-2">
        <label for="ex1">Sort By:</label>
        <select name="sort_by">
            <option value="alph">Name Z-A</option>
            <option value="rating">Descending Rating</option>
        </select>
    </div>
</div>
<form action="" method = "post">
    <div class="input-group">
        <input type="text" id="input" name="keyword" class="form-control" placeholder="Search">
        <div class="input-group-btn">
            <button class="btn btn-default" name="submit" type="submit">
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
   if(isset($_POST['submit']))
   {
       if(empty($_POST['service_type']))
           $server_service_type = '';
       else
           $server_service_type = $_POST['service_type'];
       $keyword = $_POST['keyword'];
       $minrating = $_POST['min_rating'];
       if(empty($_POST['min_rating']))
            $minrating = 0;
       else
           $minrating = $_POST['min_rating'];

       if(empty($_POST['start_date'])){
            $start = '0000-00-00';
       }
       else
           $start = $_POST['start_date'];

       if(empty($_POST['end_date'])){
           $end = '9999-12-12';
       }
       else
           $end = $_POST['end_date'];
       $search_keyword = strtolower($keyword);
      $results = array();
      $result_query = "";
      $lower_service_type = strtolower($server_service_type);
      $service_ID = $server_service_type;
      $sort = $_POST['sort_by'];
      if($sort == "alph" || $sort == '')
          $sort_by = "custom_service_name";
      if($sort == "rating")
          $sort_by = "service_rating";
       if($lower_service_type != "")
            $result_query = mysqli_query($db, "SELECT * FROM provided_services WHERE (service_starting_date BETWEEN '$start' AND '$end')
                                                                    AND service_rating >='$minrating' 
                                                                    AND service_type_ID='$service_ID' 
                                                                    AND custom_service_name LIKE '%$search_keyword%' 
                                                                    ORDER BY $sort_by DESC");
       else
           $result_query = mysqli_query($db, "SELECT * FROM provided_services WHERE (service_starting_date BETWEEN '$start' AND '$end')
                                                                                      AND service_rating >= '$minrating' 
                                                                                      AND custom_service_name LIKE '%$search_keyword%'
                                                                                      ORDER BY $sort_by DESC");
       echo "<div class=\"container\"> 
             <table style=\"background-color:#181818; color:#FFF\" class=\"table\">
             <thead class=\"thead-dark\"> 
             <tr> <th>Name </th>
                  <th>Service Rating </th>
                  <th>Starting Date </th>
                  <th>Ending Date </th>
             </tr>
             </thead>
             <tbody id=\"myTable\">";
       while($row = mysqli_fetch_array($result_query)) {
           echo "<tr onclick=\"window.location='professional_info.php?profID=$row[0]';\"> 
                <td> $row[1] </td>
                <td> $row[2] </td>
                <td> $row[3] </td>
                <td> $row[4] </td>
                </tr>";
       }
       echo "</tbody>
                </table> </div> <br><br><br>";

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