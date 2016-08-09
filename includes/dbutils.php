<?php
/**
 * Database utilities.
 *
 * @author          Andrew Jeffries.
 *
 * @version         1.0.0           Prototype
 */
if (session_status() == PHP_SESSION_NONE)
	session_start();
/**
 * Get database connection.
 *
 * @return      mysqli instance.
 * @throws      Exception           If connections fails.
 */
function databaseConnection()
{
    $authConfig = Array("host" => "localhost", "user" => "feedtheh_hungry", "password" => "Aort101ms!", "catalogue" => "feedtheh_fth");
    $mysqli = mysqli_connect($authConfig["host"], $authConfig["user"], $authConfig["password"], $authConfig["catalogue"]);
    if ($mysqli===false)
        throw new Exception("Failed to instantiate database.  Error(".mysqli_connect_errno().") - ".mysqli_connect_error());
    return $mysqli;
}

/**
 * Returns TRUE if user exists in the users table.
 *
 * @return          boolean         TRUE if they exist, FALSE if not.
 */
function is_logged()
{
    try
    {
        $dbConnection = databaseConnection();
    }
    catch(Exception $objException)
    {
        echo $objException->getMessage();
        exit(-1);
    }
    
    $userUsername = (filter_input(INPUT_POST, 'username'));
    $userPassword = (filter_input(INPUT_POST, 'password'));

    if ($stmt = $dbConnection->prepare("SELECT userName, userPassword, userStatus FROM users WHERE userName=? AND userPassword=? "))
    {
        $stmt->bind_param("ss", $userUsername, $userPassword);
        $stmt->execute();
        $stmt->store_result();
        $blnRetVal=($stmt->num_rows!=0);
        $stmt->close();
        $dbConnection->close();
        return $blnRetVal;
    }
}

// SM:  Not sure what this is?  It needs error handling added.
function secondaryConnection()
{
    $authConfig = Array("host" => "localhost", "user" => "root", "password" => "Aort101ms!", "catalogue" => "fth");
    $mysqli = mysqli_connect($authConfig["host"], $authConfig["user"], $authConfig["password"], $authConfig["catalogue"]);
    return $mysqli;
}

function processRegister() {
	
	global $dbConnection;
	
	$username = filter_input ( INPUT_POST, 'username' );
	$password = filter_input ( INPUT_POST, 'password1' );

	$fullname = filter_input ( INPUT_POST, 'fullname' );
	$email = filter_input ( INPUT_POST, 'email' );
	$phone = filter_input ( INPUT_POST, 'phone' );
	$address = filter_input ( INPUT_POST, 'address' );

	$stmt = $dbConnection->prepare ( "INSERT INTO users (userName, userPassword, userFullname, userEmail, userPhone, userAddress) VALUES (?,?,?,?,?,?)" );

	if ($stmt === false) {
		trigger_error ( $this->dbConnection->error, E_USER_ERROR );
	}

	$stmt->bind_param ( 'ssssss', $username, $password, $fullname, $email, $phone, $address );

	$status = $stmt->execute ();

	if ($status === false) {
		trigger_error ( $stmt->error, E_USER_ERROR );
	}
	echo 'You have successfully registered. <br><br><br>Please Wait.....<br>';
	echo '<meta http-equiv="refresh" content="3;url=index.php">';
}

function processMembersLogin() {
	
	global $dbConnection;
	
	$userUsername = (filter_input ( INPUT_POST, 'username' ));
	$userPassword = (filter_input ( INPUT_POST, 'password' ));

	echo '<div class="space"></div>';
	echo '<div class="space"></div>';
	
	if ($stmt = $dbConnection->prepare ( "SELECT userID, userUsername, userPassword, userStatus FROM users WHERE userUsername=? AND userPassword=? " )) {
			
		$stmt->bind_param ( "ss", $userUsername, $userPassword );
		$stmt->execute ();
			
		$stmt->store_result ();
			
		if ($stmt->num_rows) {

			$stmt->bind_result ( $userID, $userUsername, $userPassword, $userStatus );
			$stmt->fetch ();

			$_SESSION ['userUsername'] = $userUsername;
			$_SESSION ['userPassword'] = $userPassword;

			$_SESSION ['userStatus'] = $userStatus;
			$_SESSION ['userID'] = $userID;

			echo '<br><b><center> Login Successful.<br>';

			echo '<meta http-equiv="refresh" content="3;url=index.php?id=Members">';
		} else {

			echo '<br><b><center> Login UnSuccessful.<br>';
			echo '<meta http-equiv="refresh" content="3;url=index.php?id=Login">';
		}
	} else {
			
		echo 'Failed Login';
	}
}

?>