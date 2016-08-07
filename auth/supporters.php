<?php

$dbConnection = databaseConnection();
error_reporting(E_ALL);
ini_set('display_errors', '1');

class supporters
{
	#const ModuleDescription = 'Access to change all Support Information and Adverting.';
	#const ModuleAuthor = 'Sunsetcoders Development Team.';
	#const ModuleVersion = '1.0';
	
	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	
	function __construct($dbConnection)
	{
		global $dbConnection;
		
		$this->dbConnection = $dbConnection;

			$this->setPostID = filter_input(INPUT_POST, 'id');
			$this->setGetID = filter_input(INPUT_GET, 'id');
		
	}
	
	public function AddSupporter()
	{
		echo '<table>';
		echo '<tr><td>Add Supporter</td></tr>';
		echo '</table>';
		
	}
	
	public function supporters()
	{
		echo '<table cellpadding=5>';
		echo '<tr><td>Supporters <a href="web-settings.php?id=Supporters&&moduleID=AddSupporter"><button>Add Supporter</button></a></td></tr>';
		
		echo '<tr><td>Company Logo</td><td>Company Name</td><td>Company Hyperlink</td></tr>';
		$stmt = $this->dbConnection->prepare("SELECT companyName, companyLogo, companyHyperlink FROM supporters ORDER BY supporterID ");
		$stmt->execute();
		
		$stmt->bind_result($companyName, $companyLogo, $companyHyperlink);
		
		while ($checkRow = $stmt->fetch()) {
		
			echo '<tr bgcolor=white><td><img src="../Images/Logos/'.$companyLogo.'" height=50></td><td>'.$companyName.'</td><td><a href="'.$companyHyperlink.'" target="_blank">'.$companyHyperlink.'</a></td></tr>';
		}
		
		echo '</table>';
		
	}
	
}