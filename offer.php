<?php
 session_start();
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <?php include "includes/navbar.php"?>
        
        <!--Offer's details-->
        <div class="container">
            <div class="row">
                    
                <?php
                    //Connecting to database
                    include "includes/mysqlConnect.php";

                    //Retrieving data from database
                    $sql = "SELECT * FROM offers WHERE id = ".$_GET["id"];
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            /*echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";*/

                                    $now = new DateTime("now");
                                    $end = new Datetime($row["end_date"]);
                                    if($now->format('U') > $end->format('U')){
                                        $sql1 = "UPDATE offers SET active=0 WHERE id=".$row["id"];
                                        $conn->query($sql1);
                                    }
                            
                                    if($row["active"]==0){
                                    echo '<div class="container">';
                                    echo '<div class="row">';
                                    echo '<div class="col-sm-12 alert alert-success" role="alert">';
                                    echo "<strong>This offer is not active<br><br>";
                                    echo '</div></div></div>';
                                    }
                                    echo '<div class="col-md-4">';
                                        echo '<img class="img-responsive" src="'.$row["photo"].'" alt=""/>';
                                    echo '</div>';
                                    echo '<div class="col-md-8">';
                                        echo '<strong>Name: </strong>'.$row["name"].'<br><br>';
                                        echo '<strong>Breed: </strong>'.$row["breed"].'<br><br>';
                                        echo '<strong>Age: </strong>'.$row["age"].'<br><br>';
                                        echo '<strong>Gender: </strong>'.$row["gender"].'<br><br>';
                                        echo '<strong>Weight: </strong>'.$row["weight"].'<br><br>';
                                        echo '<strong>Location: </strong>'.$row["location"].'<br><br>';
                                        echo '<strong>Lineage: </strong>'.$row["lineage"].'<br><br>';
                                        echo '<strong>Behavior: </strong>'.$row["behavior"].'<br><br>';
                                        echo '<strong>Child friendliness: </strong>'.$row["child_friend"].'<br><br>';
                                        echo '<strong>Valid till: </strong>'.$row["end_date"].'<br><br>';
                            
                                        $sql1 = "SELECT * FROM users WHERE id = ".$row["user_id"];
                                        $result1 = $conn->query($sql1);
                                        $row1 = $result1->fetch_assoc();
                            
                                        echo '<strong>Contact: </strong>'.$row1["email"].'<br><br>';
                                    
                            
                            echo '</div>';

                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>

                    
                </div>


            </div>


        </div>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
</body>

</html>