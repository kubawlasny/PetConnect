<?php
    session_start();
    if ((!isset($_SESSION['zalogowany'])) || !($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
    
    // Rediricting admin to different dashboard
    if($_SESSION['admin']){
        header('Location: dashboard-admin.php');
    }
    
    // Offer activation/deactivation
    if (isset($_POST['submit_active'])){    
        $offer_id = $_POST['offer'];
        $active = $_POST['active'];
        
        
        include "includes/mysqlConnect.php";
                                
            //Updating the offer
            $sql = "UPDATE offers SET active=".$active." WHERE id=".$offer_id;

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            
            $conn->close();  

        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-sm-offset-2 col-sm-10 alert alert-success" role="alert">';
        echo "<strong>The offer has been updated!</strong>";
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

                       <li class="active"><a href="/dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
         
                    </ul>
                    
                </div>
                <!--Dashboard main content-->
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Dashboard</h1>
                    <h2>
                        <?php
                            echo "<p>Welcome ".$_SESSION['firstname'].'!</p>';
                        ?>
                    </h2>

                   <!--List of all offers added by user-->
                    <h2 class="sub-header">Your offers:</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dog's name</th>
                                    <th>Valid till</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                //Connecting to database
                                include "includes/mysqlConnect.php";
                                
                                //Retrieving data from database
                            $sql = "SELECT * FROM offers WHERE user_id = ".$_SESSION['user_id'];
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>'.$row["id"].'</td>'; 
                                    echo '<td>'.$row["name"].'</td>'; 
                                    echo '<td>'.$row["end_date"].'</td>'; 
                                    
                                    if($row["active"]==1){
                                        echo '<td>Active</td>';
                                        
                                        echo '<td><form method="post" enctype="multipart/form-data">';
                                        echo '<input type="hidden" name="offer" id="offer" value="'.$row["id"].'" />';
                                        echo '<input type="hidden" name="active" id="active" value="0" />';
                                        echo '<button type="submit" name="submit_active" class="btn">Deactivate</button>'; 
                                        echo '</form></td>';
                                        
                                    } else {
                                        echo '<td>Inactive</td>';
                                        
                                        echo '<td><form method="post" enctype="multipart/form-data">';
                                        echo '<input type="hidden" name="offer" id="offer" value="'.$row["id"].'" />';
                                        echo '<input type="hidden" name="active" id="active" value="1" />';
                                        echo '<button type="submit" name="submit_active" class="btn">Activate</button>';
                                        echo '</form></td>';
                                    }
                                    
                                    echo '<td><a href="http://pc.wlasny.kylos.pl/offer.php?id='.$row["id"].'">';
                                    echo '<button class="btn">See the offer</button>';
                                    echo '</a></td>';
                                    
                                    
                                    
                                    
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