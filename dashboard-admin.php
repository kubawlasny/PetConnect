<?php
    session_start();
    if ((!isset($_SESSION['zalogowany'])) || !($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Pet Connect</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <?php include "includes/navbar.php"?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                    
                    <li class="active"><a href="/dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
                    <li><a href="dashboard-users.php">Users</a></li>
                    <li><a href="dashboard-offers.php">Offers</a></li> 
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Dashboard</h1>
                    <h2>
                        <?php
                            echo '<div class="row">Welcome '.$_SESSION['firstname'].'! You are an administrator!</div><br>';
                        ?>
                    </h2>

                    <div class="row placeholders">
                        <div class="col-xs-6 col-sm-3 placeholder">
                            <h1>50</h1>
                            <h4>Offers</h4>
                            <span class="text-muted">That's the number of active offers</span>
                        </div>
                        <div class="col-xs-6 col-sm-3 placeholder">
                            <h1>15</h1>
                            <h4>Users</h4>
                            <span class="text-muted">Number of our users</span>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
</body>

</html>