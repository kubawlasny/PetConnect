<?php
    
    include "includes/session.php";    
    
    include "includes/mysqlConnect.php";

	// Handling user log in

	if ($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$conn->query(
		sprintf("SELECT * FROM users WHERE nickname='%s' AND password='%s'",
		mysqli_real_escape_string($conn,$login),
		mysqli_real_escape_string($conn,$haslo))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['zalogowany'] = true;
                $_SESSION['udanarejestracja']=false;
				$wiersz = $rezultat->fetch_assoc();
                $_SESSION['firstname'] = $wiersz['firstname'];
                $_SESSION['user_id'] = $wiersz['id'];
                if($wiersz['admin']=='1'){
                    $_SESSION['admin']=true;
                }
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
                
                if($wiersz['admin']){
				    header('Location: dashboard-admin.php');
                } else {
                    header('Location: dashboard.php');
                }
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$conn->close();
	}

?>