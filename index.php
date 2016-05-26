<?php
 session_start();

//including connection to database
include "includes/mysqlConnect.php";

//Updating status of all ofers in the system

//Retrieving data from database
$sql = "SELECT * FROM offers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $now = new DateTime("now");
        $end = new Datetime($row["end_date"]);
        if($now->format('U') > $end->format('U')){
            $sql1 = "UPDATE offers SET active=0 WHERE id=".$row["id"];
            $conn->query($sql1);
        }
    }
}
$conn->close();


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
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--Including navigation-->
    <?php include "includes/navbar.php"?>
        
        
    <!--Message that shows up after a successful signup-->        
    <?php
        if($_SESSION['udanarejestracja']){
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-sm-12 alert alert-success" role="alert">';
        echo "<strong>Account created successfully!</strong> Please log in to use the service.<br><br>";
        echo '</div></div></div>'; 
    }
    ?>
       
       <!--Slider-->
        <div class="container-fluid">
            <div class="row">
                <div class="flexslider col-md-12">
                  <ul class="slides">
                    <li>
                      <img src="photos/1.jpg" />
                    </li>
                    <li>
                      <img src="photos/2.jpg" />
                    </li>
                    <li>
                      <img src="photos/3.jpg" />
                    </li>
                  </ul>
                </div>
            </div>
        </div>
        
        <!--Displaying recent offers-->
        <div class="container">
            <div class="row placeholders">
                <h1>Recent offers</h1><br>
                
                <?php
                //Connecting to database
                include "includes/mysqlConnect.php";

                //Retrieving data from database
                $sql = "SELECT * FROM offers ORDER BY id DESC LIMIT 4";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        if($row["active"]==1){

                            echo '<div class="col-xs-6 col-sm-3 placeholder">';
                            echo '<img src="'.$row["photo"].'" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">';
                            echo '<h4>'.$row["name"].'</h4>';
                            echo '<span class="text-muted">'.$row["breed"].' - '.$row["age"].' years old</span>';
                            echo '</div>';
                        }

                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
                
            </div>
            
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.flexslider-min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
              $('.flexslider').flexslider({
                animation: "slide",
                controlNav: true,
                directionNav: true
              });
            });
        </script>
</body>

</html>