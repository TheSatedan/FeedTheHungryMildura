<?php

$dbConnection = databaseConnection ();

function membersScreen() {
	
	global $dbConnection;
	
	$userUsername = $_SESSION ['userUsername'];
	$pageID = filter_input ( INPUT_GET, 'pageID' ) ? filter_input ( INPUT_GET, 'pageID' ) : 1;
	
	if ($stmt = $dbConnection->prepare ( "SELECT userID, userFullName, userEmail, userPhone, userAddress, userStatus, userSupport, userNewsletter FROM users WHERE userUsername=? " )) {
		
		$stmt->bind_param ( "s", $userUsername );
		$stmt->execute ();
		
		$stmt->bind_result ( $userID, $userFullName, $userEmail, $userPhone, $userAddress, $userStatus, $userSupport, $userNewsletter );
		$stmt->fetch ();
		
		echo '<div class="clientInformation">' . $userFullName . ' <br> ' . $userAddress . '<br>' . $userPhone . '<br>' . $userEmail . '<br><hr><br>' . $userStatus . '</div>';
		
		echo '<div class="titleMenu"><a href="index.php?id=Members&&pageID=ProfileEditor">Profile Editor</a></div>';
		echo '<div class="titleMenu"><a href="index.php?id=Members&&pageID=VeggieSwap">Vegetable Swap</a></div>';
		echo '<div class="titleMenu"><a href="index.php?id=Members&&pageID=Accommodation">Accommodation</a></div>';
		echo '<div class="titleMenu"><a href="index.php?id=Members&&pageID=HelpLine">Help Line</a></div>';
		echo '<div style="clear: both"></div>';
		

	}

}
function accommodation() {
	
	global $dbConnection;
	
	$stmt = $dbConnection->prepare ( "SELECT imageName, imageHyperlink FROM fader ORDER BY imageID " );
	$stmt->execute ();
	
	$stmt->bind_result ( $imageName, $imageHyperlink );
	
	while ( $checkRow = $stmt->fetch () ) {
			
		echo '<figure><img src="Images/' . $imageName . '"  /></figure>';
	}
	
}
function helpline() {
	
	global $dbConnection;
	
	$val = mysqli_query ( $dbConnection, 'select 1 from `helpline` LIMIT 1' );
	
	if ($val !== FALSE) {
	} else {
		echo 'Table Doesnt Exist....';
	
		$createTable = $dbConnection->prepare ( "CREATE TABLE helpline (helplineID INT(11) AUTO_INCREMENT PRIMARY KEY, userID INT(11) NOT NULL, helplineDescription VARCHAR(10000) NOT NULL)" );
		$createTable->execute ();
		$createTable->close ();
	
		echo 'Table Created.';
	}
	
	
	echo 'HelpLine needed';
	
}
function editProfile() {
	
	global $dbConnection;
	
	echo '<div class="body-content">';
	
	$userUsername = $_SESSION ['userUsername'];
	
	if ($stmt = $dbConnection->prepare ( "SELECT userID, userFullName, userEmail, userPhone, userAddress, userStatus, userSupport, userNewsletter FROM users WHERE userUsername=? " )) {
	
		$stmt->bind_param ( "s", $userUsername );
		$stmt->execute ();
	
		$stmt->bind_result ( $userID, $userFullName, $userEmail, $userPhone, $userAddress, $userStatus, $userSupport, $userNewsletter );
		$stmt->fetch ();
	
		echo '<div class="clientInformation">' . $userFullName . ' <br> ' . $userAddress . '<br>' . $userPhone . '<br>' . $userEmail . '<br><hr><br>' . $userStatus . '</div>';
	
	}
	echo '</div>';
}
function vegetableSwap() {
	
	global $dbConnection;
	
	$stmt = $dbConnection->prepare ( "SELECT imageName, imageHyperlink FROM fader ORDER BY imageID " );
	$stmt->execute ();
	
	$stmt->bind_result ( $imageName, $imageHyperlink );
	
	while ( $checkRow = $stmt->fetch () ) {
			
		echo '<figure><img src="Images/' . $imageName . '"  /></figure>';
	}
	
}

function wishlist()
{
	global $dbConnection;
	
	echo '<div class="space"></div>';
	echo '<div class="orangeBox"></div>';
	
	echo '<div class="body-content">';
	echo '<br><br><h1>Requested Items</h1>';
	
	if ($stmt = $dbConnection->prepare ( "SELECT wishlistName FROM wishlist WHERE donationDate='0000-00-00' " )) {
	
		$stmt->execute ();
	
		$stmt->bind_result ( $wishlistName );
		$stmt->fetch ();
	
		echo '<div class="clientInformation">' . $wishlistName . '</div>';
	
	}
	echo '</div>';
	
}
	