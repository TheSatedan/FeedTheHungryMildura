<?php

$dbConnection = databaseConnection();


class users
{
	const ModuleDescription = 'Monitor Donations from Companys and Members.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '1.0';
	
	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	
	function __construct($dbConnection)
	{
		
		$this->dbConnection = $dbConnection;

			$this->setPostID = filter_input(INPUT_POST, 'id');
			$this->setGetID = filter_input(INPUT_GET, 'id');
		
	}
	
	public function users()
	{
		echo '<table cellpadding=5>';
		echo '<tr><td>Users <a href="web-settings.php?id=Users&&moduleID=AddUser"><button>Add User</button></a></td></tr>';
		
		echo '<tr><td>Fullname</td><td>Email</td><td>Phone</td><td>Role</td><td>Newsletter</td></tr>';
		$stmt = $this->dbConnection->prepare("SELECT userFullName, userEmail, userPhone, userStatus, userNewsletter FROM users ORDER BY userFullName ");
		$stmt->execute();
		
		$stmt->bind_result($userFullName, $userEmail, $userPhone, $userStatus, $userNewsletter);
		
		while ($checkRow = $stmt->fetch()) {
		
			echo '<tr bgcolor=white><td>'.$userFullName.'</td><td>'.$userEmail.'</td><td>'.$userPhone.'</td><td>'.$userStatus.'</td><td>'.$userNewsletter.'</td></tr>';
		}
		
		echo '</table>';
		
	}
	
	public function addUser()
	{
		echo '<form method="POST" action="web-settings.php?id=Users&&moduleID=UploadUser">';
		echo '<table cellpadding=5 border=1 cellspacing=0 width=60%>';
		echo '<tr><td colspan=2>Add Users Page.</td></tr>';
		echo '<tr bgcolor=white><td colspan=2>&nbsp;</td></tr>';
		echo '<tr><td colspan=2 align=right>Personal Information</td></tr>';
		echo '<tr bgcolor=white><td align=right>FullName</td><td><input type="text" name="userFullname" placeholder="FullName" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Email</td><td><input type="text" name="userEmail" placeholder="Email Address" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Phone</td><td><input type="text" name="userPhone" placeholder="Phone Number" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Address</td><td><input type="text" name="userAddress" placeholder="Address" required></td></tr>';
		
		echo '<tr><td colspan=2 align=right>Subscriptions</td></tr>';
		echo '<tr bgcolor=white><td align=right>Newsletter</td><td><input type="checkbox" name="userNewsletter" value="Yes"></td></tr>';
		
		echo '<tr><td colspan=2 align=right>Database Access</td></tr>';
		echo '<tr bgcolor=white><td align=right>UserName</td><td><input type="text" name="userUsername" placeholder="Username" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Password</td><td><input type="password" name="userPassword1" placeholder="Password" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Confirm Password</td><td><input type="password" name="userPassword2" placeholder="Confirm Password" required></td></tr>';
		echo '<tr bgcolor=white><td align=right>Domestic Abuse</td><td>';
		
		echo '<select name="userDomestic" required>';
		echo '<option value=NULL>Select Status</option>';
		echo '<option value="No">Not Involved</option>';
		echo '<option value="Yes">Require Help</option>';
		echo '<option value="Admin">Set As Admin</option>';
		echo '</select>';
		
		
		
		echo '</td></tr>';
		echo '<tr bgcolor=white><td align=right>User Status</td><td>';
		
		echo '<select name="userStatus" required>';
		echo '<option value=NULL>Select Role</option>';
		echo '<option>Member</option>';
		echo '<option>Administrator</option>';
		echo '</select>';
		
		echo '</td></tr>';
		echo '<tr><td colspan=2 align=right><input type="submit" name="submit" value="Create User"></td></tr>';
		echo '</table>';
	
	}
	
	public function uploaduser()
	{
		$setFullname = filter_input ( INPUT_POST, 'userFullname' );
		$setEmail = filter_input ( INPUT_POST, 'userEmail' );
		$userPhone = filter_input ( INPUT_POST, 'userPhone' );
		$userAddress = filter_input ( INPUT_POST, 'userAddress' );
		$userNewsletter = filter_input ( INPUT_POST, 'userNewsletter' );
		$userUsername = filter_input ( INPUT_POST, 'userUsername' );		
		$userPassword1 = filter_input ( INPUT_POST, 'userPassword1' );
		$userPassword2 = filter_input ( INPUT_POST, 'userPassword2' );
		$userDomestic = filter_input ( INPUT_POST, 'userDomestic' );
		$userStatus = filter_input ( INPUT_POST, 'userStatus' );
		$setDate = date('Y-m-d');
		
		if ($userPassword1 == $userPassword2) {
				
			$stmt = $this->dbConnection->prepare ( "INSERT INTO users (userUsername, userPassword, userFullName, userEmail, userPhone, userAddress, userStatus, userSupport, userJoined, userNewsletter) VALUES (?,?,?,?,?,?,?,?,?,?)" );
			$stmt->bind_param ( 'ssssssssss', $userUsername, $userPassword1, $setFullname, $setEmail, $userPhone, $userAddress, $userStatus, $userDomestic, $setDate, $userNewsletter );
				
			$status = $stmt->execute ();
				
			echo 'You have successfully registered a new User. <br><br><br>Please Wait.....<br>';
		} else {
			echo 'Password MisMatch!';
		}
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Users">';
	}

	public function EditUser()
	{
		echo '<table>';
		echo '<tr><td>Edit Users Page.</td></tr>';
		echo '</table>';
	
	}
	
	private function updateUser()
	{
	
	}
}