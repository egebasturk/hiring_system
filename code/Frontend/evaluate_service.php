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
      <tr>
        <!--BURALARA PHP SERPİŞTİRİLECEK-->
        <td>Buğra</td>
        <td>Ankara</td>
        <td>5 years</td>
        <td>House cleaning</td>
        <td>6/10</td>
        <!--BURALARA PHP SERPİŞTİRİLECEK-->
      </tr>
    </tbody>
  </table>
    <div class="container">
        <form class="form-horizontal" action="/action_page.php" method="POST">
            <div class="form-group">
                <label for="eval">Please evaluate your service</label>
                <input type="number" min="0" max="10" class="form-control" id="eval">
            </div>

            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" id="comment"></textarea>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-0">
                    <button type="submit" class="btn btn-warning">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>



</body>
</html>