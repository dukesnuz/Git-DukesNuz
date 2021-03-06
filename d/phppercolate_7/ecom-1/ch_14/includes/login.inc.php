<?php
 //login.inc.php
 
 $login_errors = array();
 
 //validate email address
 
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
//if(4>2)
{
	$e = escape_data($_POST['email'], $dbc);
} else {
	$login_errors['email'] = 'Please enter a valid email address!';
}

	
 //validate the password
 
if (!empty($_POST['pass'])) 
//if(4>6)
    {
	$p = $_POST['pass'];
    } else {
	$login_errors['pass'] = 'Please enter your password!';
    }
	
if (empty($login_errors)) 
     { // OK to proceed!

	// Query the database:
	//changed in cp 12 page 395
	/*
	$q = "SELECT id, username, type, pass, IF(date_expires >= NOW(), true, false) AS expired FROM users 
	    WHERE email='$e'";	   
	$r = mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) === 1) { 
		// Get the data:
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC); 
		*/
	//END in chp 12 page 395
	//START prepared statement
	 //not checked for errors
	$q ="SELECT id, username, type, pass, IF(date_expires >= NOW(), true, false)
		AS expired FROM users 
		WHERE email = ? ";
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 's',$e);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt) === 1)
			{
			mysqli_stmt_bind_results($stmt, $user_id,$username,$type,$pass, $expired);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			
	 	if (password_verify($p, $row['pass'])) { // Correct!
			 
			if ($row['type'] === 'admin') {
				session_regenerate_id(true);
				$_SESSION['user_admin'] = true;
			}
		
			// Store the data in a session:
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['username'] = $row['username'];

			   // Only indicate if the user's account is not expired:
			   if ($row['expired'] === 1) $_SESSION['user_not_expired'] = true;
			
		        } else { // Right email address, invalid password.
			     $login_errors['login'] = 'The email address and password do not match those on file.';
		         }
	
	} else { // No match was made. (technically, only the email address failed)
		$login_errors['login'] = 'The email address and password do not match those on file.';
	}
	
} // End of $login_errors IF.

// Omit the closing PHP tag to avoid 'headers already sent' errors!