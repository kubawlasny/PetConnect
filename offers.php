<?php
 session_start();

//Filtering results
$filter = "";

if (isset($_POST['submit'])) {
    
    if($_POST['breedSelect']=="all"){
        $breed="";
    } else {
        $breed=" WHERE breed = '".$_POST['breedSelect']."'";
    }
    
    if($_POST['locationInput']=="all"){
        $location="";
    } else if ($_POST['breedSelect']=="all"){
        $location=" WHERE location = '".$_POST['locationInput']."'";
    } else {
        $location=" AND location = '".$_POST['locationInput']."'";
    }
    
    $filter=$breed.$location;
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
       
        <div class="container">
           
           <!--Filters form-->
            <div class="row">
                <div class="col-md-12">
                    <h2>Filters</h2>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-3">
                            <label for="breedSelect">Breed</label>
                            <select class="form-control" id="breedSelect" name="breedSelect" required>
                                <option value="all">all</option>
                                <option value="Beagle">Beagle</option>
                                <option value="Boxer">Boxer</option>
                                <option value="Bulldog">Bulldog</option>
                                <option value="Chihuahua">Chihuahua</option>
                                <option value="Dachshund">Dachshund</option>
                                <option value="Doberman Pinscher">Doberman Pinscher</option>
                                <option value="French Bulldog">French Bulldog</option>
                                <option value="German Shepherd">German Shepherd</option>
                                <option value="Golden Retriever">Golden Retriever</option>
                                <option value="Husky">Husky</option>
                                <option value="Labrador RetrievPoodleer">Labrador Retriever</option>
                                <option value="Poodle">Poodle</option>
                                <option value="Pug">Pug</option>
                                <option value="Rottweiler">Rottweiler</option>
                                <option value="Yorkshire Terrier">Yorkshire Terrier</option>
                                <option value="Other">Other</option>    
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="locationInput">Location (voivodeship)</label>
                            <select class="form-control" id="locationInput" name="locationInput" required>
                                <option value="all">all locations</option>
                                <option value="dolnośląskie">dolnośląskie</option>
                                <option value="kujawsko-pomorskie">kujawsko-pomorskie</option>
                                <option value="lubelskie">lubelskie</option>
                                <option value="lubuskie">lubuskie</option>
                                <option value="łódzkie">łódzkie</option>
                                <option value="małopolskie">małopolskie</option>
                                <option value="mazowieckie">mazowieckie</option>
                                <option value="opolskie">opolskie</option>
                                <option value="podkarpackie">podkarpackie</option>
                                <option value="podlaskie">podlaskie</option>
                                <option value="pomorskie">pomorskie</option>
                                <option value="śląskie">śląskie</option>
                                <option value="świętokrzyskie">świętokrzyskie</option>
                                <option value="warmińsko-mazurskie">warmińsko-mazurskie</option>
                                <option value="wielkopolskie">wielkopolskie</option>warmińsko-mazurskie
                                <option value="zachodniopomorskie">zachodniopomorskie</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" name="submit" class="btn btn-default">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!--List of all offers-->
            <div class="row">
                <?php
                    //Connecting to database
                    include "includes/mysqlConnect.php";

                    //Retrieving data from database
                    $sql = "SELECT * FROM offers".$filter;
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {

                            // Checking if the offer expired
                            $now = new DateTime("now");
                            $end = new Datetime($row["end_date"]);
                            if($now->format('U') > $end->format('U')){
                                $sql1 = "UPDATE offers SET active=0 WHERE id=".$row["id"];
                                $conn->query($sql1);
                            }

                            if($row["active"]==1){

                                echo '<div class="row">';
                                echo '<div class="photo col-md-4" style="background-image: url('.$row["photo"].')">'.'</div>'; 
                                echo '<div class="col-md-8">';
                                echo '<h1>'.$row["name"].'</h1><br>';
                                echo $row["breed"].' - '.$row["age"].' years old<br>';
                                echo 'Valid till '.$row["end_date"].'<br>';


                                if ((isset($_SESSION['zalogowany'])) || ($_SESSION['zalogowany']==true))
                                {
                                    echo '<a href="http://pc.wlasny.kylos.pl/offer.php?id='.$row["id"].'">';
                                    echo '<button class="btn">See more</button>';
                                    echo '</a>';
                                } else {
                                    echo '<div class="alert alert-info" role="alert">Please, log in to see the details</div>';
                                }

                                echo '</div>';
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
</body>

</html>