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
  <h1>Service Evaluation</h1>        
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Experience</th>
        <th>Expertise Field</th>
        <th>Rating</th>
      </tr>
    </thead>
    <tbody>
      <?php
            include('config.php');
            session_start();
            if(isset($_GET['email']))
            {
                $provider = $_GET['email'];
                $provider_city = $_GET['city'];
                $provider_experience = $_GET['exp'];
                $provider_expertise = $_GET['expertise'];
                $service_rating = $_GET['rating'];
                $service_eval = $_GET['eval'];
                echo "<tr>";
                echo "<td> $provider </td>";
                echo "<td> $provider_city </td>";
                echo "<td> $provider_experience </td>";
                echo "<td> $provider_expertise </td>";
                echo "<td> $service_rating/10</td>";
                echo "</tr>";
                $provider_ID = $_GET['provider'];
                $user_ID = $_SESSION['user_ID'];
                if(isset($_POST['send']))
                {
                    $comment = "" ;
                    $rating = 0;

                    if(empty($_POST['comment']))
                    {
                        $comment = $service_eval ;

                    }
                    else
                    {
                        $comment = $_POST['comment'];
                    }

                    if(empty($_POST['rating']))
                    {
                        $rating = $service_rating;
                    }
                    else
                    {
                        $rating = $_POST['rating'];
                    }
                    $sql = mysqli_query($db, "UPDATE service_ratings_evaluations SET rating='$rating', evaluation='$comment' WHERE user_ID = $user_ID AND provider_ID = $provider_ID");
                    header('Location: evaluate_service.php?email='.$provider.'&city='.$provider_city.'&exp='.$provider_experience.'&expertise='.$provider_expertise.'&rating='.$rating.'&eval='.$comment.'&provider='.$provider_ID);
                }
                if(isset($_POST['back']))
                {
                    header('Location: past_services.php');
                }
            }
      ?>
    </tbody>
  </table>
    <div class="container">
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="eval">Please evaluate your service</label>
                <input type="number" min="0" max="10" class="form-control" name="rating">
            </div>

            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" name="comment"><?php echo $service_eval;?></textarea>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-0">
                    <button type="submit" class="btn btn-warning" name="send">Send</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-0">
                    <button type="submit" class="btn btn-warning" name="back">Back</button>
                </div>
            </div>

        </form>
    </div>
</div>



</body>
</html>