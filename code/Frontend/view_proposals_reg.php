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
            <th>Starting Date</th>
            <th>Ending Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <td>9000</td>
            <td>Moving</td>
            <td>01.01.1970</td>
            <td>01.01.2010</td>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
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
        <tr>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
            <td>9000</td>
            <td>01.01.1970</td>
            <td>01.01.2010</td>
            <td>300</td>
            <td>
                <form action="" method="post">
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-0">
                            <button type="submit" name="add" class="btn btn-warning">Add</button>
                        </div>
                    </div>
                </form>
            </td>
            <td>
                <form action="" method="post">
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-0">
                            <button type="submit" name="remove" class="btn btn-danger">Remove</button>
                        </div>
                    </div>
                </form>
            </td>
            <!--BURALARA PHP SERPİŞTİRİLECEK-->
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>