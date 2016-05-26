<?php 

session_start();
// Redirecting user to Homepage if not logged in
if ((!isset($_SESSION['zalogowany'])) || !($_SESSION['zalogowany']==true))
{
    header('Location: index.php');
    exit();
}

// Handling the offer addition form
if (isset($_POST['submit'])) {
    
    
    /*photos*/
    $uploadDir = 'photos/';

    $fileName = $_FILES['photoInput']['name'];
    $tmpName = $_FILES['photoInput']['tmp_name'];
    $fileSize = $_FILES['photoInput']['size'];
    $fileType = $_FILES['photoInput']['type'];
    $fileHash = md5_file($_FILES['photoInput']['tmp_name']);

    /*$filePath = $uploadDir . $fileName;*/
    $filePath = $uploadDir . $fileHash;
    

    $result = move_uploaded_file($tmpName, $filePath);
    if (!$result) {
    echo "Error uploading file";
    exit;
    }

    if(!get_magic_quotes_gpc())
    {
    $fileName = addslashes($fileName);
    $filePath = addslashes($filePath);
    }
    
    include "includes/mysqlConnect.php";
    
    $user_id = $_SESSION['user_id'];
    $name = $_POST['nameInput'];   
    $breed = $_POST['breedSelect'];   
    $age = $_POST['ageInput'];   
    $gender = $_POST['inlineRadioOptions'];   
    $weight = $_POST['weightInput'];   
    $location = $_POST['locationInput'];   
    $lineage = $_POST['lineageRadioOptions'];   
    $behavior = $_POST['behaviorSelect'];   
    $friendliness = $_POST['friendlinessSelect'];   
    $end_date = date("Y-m-d", time() + $_POST['endDateSelect']*86400);   
    $photo = 'http://pc.wlasny.kylos.pl/'.$filePath;
    //$photo = 'http://pc.wlasny.kylos.pl/pug.jpg';
    
    
    $sql = "INSERT INTO offers (id, user_id, name, breed, age, gender, weight, location, lineage, behavior, child_friend, end_date, photo, active) VALUES ('', '$user_id', '$name', '$breed', '$age', '$gender', '$weight', '$location', '$lineage', '$behavior', '$friendliness', '$end_date', '$photo', '1')";
    
    if(mysqli_query($conn, $sql)){
        
        $sql1="SELECT * FROM offers ORDER BY id DESC LIMIT 1";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        $offer_id = $row1['id'];
        
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-sm-12 alert alert-success" role="alert">';
        echo "<strong>Offer added successfully!</strong> Would you like to see it?<br><br>";
        echo '<a href="http://pc.wlasny.kylos.pl/offer.php?id='.$offer_id.'">';
        echo '<button type="button" class="btn btn-success">Show the offer</button>';
        echo '</a>';
        echo '</div></div></div>';                            
        
    } else{
        echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
    }

// close connection
    $conn->close();
    
    
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
            <div class="row">
                <div class="col-sm-12">
                    <h1>Add an offer</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h2>Dog's details:</h2>
                    
                    <!-- Offer addition form-->
                    <form method="post" enctype="multipart/form-data">
                       
                        <!-- Dog's name -->
                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input type="text" class="form-control" id="nameInput" name="nameInput" placeholder="Your dog's name" required>
                        </div>
                        
                        <!-- Dog's breed - select - all the available options shoul be retrieved from db model-->
                        <div class="form-group">
                            <label for="breedSelect">Breed</label>
                            <select class="form-control" id="breedSelect" name="breedSelect" required>
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
                        
                        <!-- Dog's age -->
                        <div class="form-group">
                            <label for="ageInput">Age</label>
                            <input type="number" min="0" class="form-control" id="ageInput" name="ageInput" placeholder="Your dog's age in years" required>
                        </div>
                        
                        <!-- Dog's gender -->
                        <div class="form-group">
                            <label>Gender</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="m" required> Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="f"> Female
                            </label>
                        </div>
                        
                        <!-- Dog's weight -->
                        <div class="form-group">
                            <label for="weightInput">Weight</label>
                            <input type="number" min="0" class="form-control" id="weightInput" name="weightInput" placeholder="Your dog's weight in kilograms" required>
                        </div>
                        
                        <!-- Dog's location -->
                        <!--<div class="form-group">
                            <label for="locationInput">Location</label>
                            <input type="text" class="form-control" id="locationInput" name="locationInput" placeholder="Your location" required>
                        </div>
                        -->
                        <div class="form-group">
                            <label for="locationInput">Location (voivodeship)</label>
                            <select class="form-control" id="locationInput" name="locationInput" required>
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
                        
                        <!-- Dog's lineage status -->
                        <div class="form-group">
                            <label>Lineage</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="lineageRadioOptions" id="lineageRadio1" value="1" required> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lineageRadioOptions" id="lineageRadio2" value="0"> No
                            </label>
                        </div>

                        <!-- Dog's behavior type - way of adding options with php needed-->
                        <div class="form-group">
                            <label for="behaviorSelect">Behavior</label>
                            <select class="form-control" id="behaviorSelect" name="behaviorSelect" required>
                                <option value="friendly">friendly</option>
                                <option value="calm">calm</option>
                                <option value="anxious">anxious</option>
                                <option value="agressive">agressive</option>
                            </select>
                        </div>
                        
                        <!-- Dog's child friendliness type - way of adding options with php needed-->
                        <div class="form-group">
                            <label for="friendlinessSelect">Child friendliness</label>
                            <select class="form-control" id="friendlinessSelect" name="friendlinessSelect" required>
                                <option value="friendly">friendly</option>
                                <option value="indifferent">indifferent</option>
                                <option value="unfriendly">unfriendly</option>
                                <option value="not sure">not sure</option>
                            </select>
                        </div>
                        
                        <!-- Offer's end date -->
                        <div class="form-group">
                            <label for="endDateSelect">Offer's duration time in days</label>
                            <select class="form-control" id="endDateSelect" name="endDateSelect" required>
                                <option value="7">7</option>
                                <option value="14">14</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        
                        <!--Photo of the dog-->
                        
                        <div class="form-group">
                            <label for="photoInput">Photo</label>
                            <!-- File size verification-->
                            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                            <input type="file" id="photoInput" name="photoInput">
                            <p class="help-block">Please add JPEG files with maximum size of 300kB</p>
                        </div>

                        <button type="submit" name="submit" class="btn btn-default">Add</button>
                    </form>

                </div>
            </div>


        </div>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
</body>

</html>