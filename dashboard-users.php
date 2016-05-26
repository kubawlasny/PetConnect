<?php
    session_start();
	
    if ((!isset($_SESSION['zalogowany'])) || !($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
    
    // Handling user warning
    if (isset($_POST['submit'])){    
        $to      = $_POST['email']
        $subject = 'Pet Connetct - warning';
        $message = 'You have been warned! Please use our service responsibly!';
        $headers = 'From: kubawlasny@poczta.fm' . "\r\n" .
            'Reply-To: kubawlasny@poczta.fm' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        
        echo $to;
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-sm-12 alert alert-success" role="alert">';
        echo "<strong>The user has been warned!</strong>";
        echo '</div></div></div>'; 
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
               <!--Sidebar-->
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="/dashboard.php">Overview</a></li>
                        <li class="active"><a href="/dashboard-users.php">Users <span class="sr-only">(current)</span></a></li>
                        <li><a href="dashboard-offers.php">Offers</a></li>
                    </ul>

                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Users</h1>
                    List of all users
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nickname</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email address</th>
                                    <th>Admin</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                //Connecting to database
                                include "includes/mysqlConnect.php";
                                
                                //Retrieving data from database
                            $sql = "SELECT * FROM users";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>'.$row["id"].'</td>'; 
                                    echo '<td>'.$row["nickname"].'</td>'; 
                                    echo '<td>'.$row["firstname"].'</td>'; 
                                    echo '<td>'.$row["lastname"].'</td>'; 
                                    echo '<td>'.$row["email"].'</td>'; 
                                    
                                    if($row["admin"]==1){
                                        echo '<td>Yes</td>';
                                        echo '<td></td>';
                                    } else {
                                        echo '<td>No</td>';
                                        echo '<td><form method="post" enctype="multipart/form-data">';
                                        echo '<input type="hidden" name="email" id="email" value="'.$row["email"].'" />';
                                        echo '<button type="submit" name="submit" class="btn">Warn user</button>'; 
                                        echo '</form></td>';
                                    }
                                    
                                    echo '</tr>';
                                }
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                                
                                
                                ?>
                            </tbody>
                        </table>
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