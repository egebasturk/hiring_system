<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>


<div class="container">
  <h1>Manage account</h1>
    <form action="" method="post">
    <div class="form-group">
      <label for="usr">Username:</label>
      <input type="text" class="form-control" id="usr" name="username">
    </div>

    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
      <label for="mail">E-mail:</label>
      <input type="email" class="form-control" id="mail" name="mail">
    </div>  

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>  

    <div class="form-group">
      <label for="surname">Surname:</label>
      <input type="text" class="form-control" id="surname" name="surname">
    </div>   

    <div class="form-group">
      <label for="dob">Date of birth:</label>
      <input type="date" class="form-control" id="dob" name="dob">
    </div>   

    <div class="form-group">
      <label for="city">City:</label>
      <input type="text" class="form-control" id="city" name="city">
    </div>   

    <div class="form-group">
      <label for="street">Street no:</label>
      <input type="text" min="0" class="form-control" id="street" name="street">
    </div>  

    <div class="form-group">
      <label for="apt">Apartment name:</label>
      <input type="text" class="form-control" id="apt" name="apt">
    </div>  

    <div class="form-group">
      <label for="zip">Zip code:</label>
      <input type="text" min="0" class="form-control" id="zip" name="zip">
    </div>   
    <div class="form-group">        
      <div class="col-sm-offset-0 col-sm-0">
        <button type="submit" name="submit" class="btn btn-warning">Update</button>
      </div>
    </div>
  </form>
  </div>
</body>
</html>