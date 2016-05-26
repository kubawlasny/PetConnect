<?php 

session_start();

//Redirecting users to Homepage if they are already logged in
if ((isset($_SESSION['zalogowany'])) || ($_SESSION['zalogowany']==true))
{
    header('Location: index.php');
    exit();
}

//Handling user signup
if (isset($_POST['submit'])) {
    
    $wszystko_OK=true;
    
    $firstname = $_POST['firstname'];   
    $lastname = $_POST['lastname'];      
    $email = $_POST['email'];   
    $nickname = $_POST['nickname'];   
    $gender = $_POST['inlineRadioOptions'];     
    $date = $_POST['date'];   
    $user_password = $_POST['password'];
    
    include "includes/mysqlConnect.php";
    
    try 
		{
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$result = $conn->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($conn->error);
				
				$ile_takich_maili = $result->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$result = $conn->query("SELECT id FROM users WHERE nickname='$nickname'");
				
				if (!$result) throw new Exception($conn->error);
				
				$ile_takich_nickow = $result->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nickname']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					
					if ($conn->query("INSERT INTO users VALUES ('', '$firstname', '$lastname', '$email', '$nickname', '$gender', '$date', '0', '$user_password')"))
					{
						$_SESSION['udanarejestracja']=true;
                        $_SESSION['zalogowany'] = false;
                        
						header('Location: index.php');
					}
					else
					{
						throw new Exception($conn->error);
					}
					
				}
				
				$conn->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Please try again later.</span>';
			echo '<br />Developer info: '.$e;
		}
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
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
                    <h1>Create a user account</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h3>Insert following information about yourself</h3>

                    <!-- Signup form-->
                    <form method="post" enctype="multipart/form-data">
                        <!-- Firstname -->
                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input type="text" class="form-control" id="nameInput" name="firstname" placeholder="Your firstname" required>
                        </div>
                        
                        <!-- Lastname -->
                        <div class="form-group">
                            <label for="lastnameInput">Name</label>
                            <input type="text" class="form-control" id="lastnameInput" name="lastname" placeholder="Your lastname" required>
                        </div>
                        
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="emailInput">Email address</label>
                            <input type="email" class="form-control" id="emailInput" name="email" placeholder="Your email address" required>
                        </div>
                        
                        <!-- Nickname -->
                        <div class="form-group">
                            <label for="nicknameInput">Nickname</label>
                            <input type="text" class="form-control" id="nicknameInput" name="nickname" placeholder="Your nickname" required>
                        </div>
                        
                        <!-- Gender -->
                        <div class="form-group">
                            <label>Gender</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="m" required> Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="f"> Female
                            </label>
                        </div>
                        
                        <!-- Date of birth -->
                        <div class="form-group">
                            <label for="dateInput">Date of birth</label>                            
                            <input type="datetime" class="form-control form_datetime" readonly id="dateInput" name="date" placeholder="" required>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="passwordInput">Password</label>
                            <input type="password" class="form-control" id="passwordInput" name="password" placeholder="" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-default">Sign up!</button>
                    </form>

                </div>
            </div>


        </div>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
            $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        </script>
</body>

</html>