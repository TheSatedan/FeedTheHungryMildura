<?php

$dbConnection = databaseConnection();


class contenteditor
{
	#const ModuleDescription = 'This Module Allows access to change all Content on pages in a text Editor.';
	#const ModuleAuthor = 'Sunsetcoders Development Team.';
	#const ModuleVersion = '1.0';
	
	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	
	function __construct($dbConnection)
	{
		global $dbConnection;
		
		$this->dbConnection = $dbConnection;

		$this->setPostID = filter_input(INPUT_POST, 'moduleID');
		$this->setGetID = filter_input(INPUT_GET, 'moduleID');
		
	}
	
	public function contenteditor()
	{
		echo '<table width=100% cellpadding=5 cellspacing=0 border=1>';
		echo '<tr><td>Content Location</td></tr>';
		$stmt = $this->dbConnection->prepare ( "SELECT aboutID, aboutLocation FROM about" );
		$stmt->execute ();
		
		$stmt->bind_result ( $aboutID, $aboutLocation );
		
		while ( $checkRow = $stmt->fetch () ) {
				
			echo '<tr bgcolor=white><td width="100"><a href="web-settings.php?id=Contenteditor&&moduleID=editContent&&aboutID='.$aboutID.'">'.$aboutLocation.'</a></td></tr>';
		}
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<tr><td>Services Content</td></tr>';
		$stmt = $this->dbConnection->prepare ( "SELECT serviceID, serviceName FROM services" );
		$stmt->execute ();
		
		$stmt->bind_result ( $serviceID, $serviceName );
		
		while ( $checkRow = $stmt->fetch () ) {
		
			echo '<tr bgcolor=white><td width="100"><a href="web-settings.php?id=Contenteditor&&moduleID=editContent&&serviceID='.$serviceID.'">'.$serviceName.'</a></td></tr>';
		}

		echo '</table>';
	}
	public function addcontent()
	{
		echo 'add Editor';
	}
	public function uploadcontent()
	{
		echo 'upload Editor';
	}
	

	
	public function editContent()
	{
		?>
		<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
		<script type="text/javascript"> bkLib.onDomLoaded(function () { nicEditors.allTextAreas() });  </script>
		<?php
		
		$setAboutID = filter_input(INPUT_GET, 'aboutID');
		$setServiceID = filter_input(INPUT_GET, 'serviceID');
		
		echo 'Content Editor<br>';
		echo '<form method="POST" action="web-settings.php?id=Contenteditor&&moduleID=updatecontent">';
		
		if ($setAboutID)
		{
			$contentID = $setAboutID;
			
			echo '<input type="hidden" name="aboutID" value="'.$setAboutID.'">';
			$query = "SELECT aboutID, aboutDescription FROM about WHERE aboutID=? ";
		
		} elseif ($setServiceID)
		{
			$contentID = $setServiceID;
			
			echo '<input type="hidden" name="serviceID" value="'.$setServiceID.'">';
			$query = "SELECT serviceID, serviceDescription FROM services WHERE serviceID=? ";
		}
		
		if ($stmt = $this->dbConnection->prepare ( $query )) {
		
			$stmt->bind_param ( "i", $contentID );
			$stmt->execute ();
		
			$stmt->bind_result ( $contentID, $contentDescription );
			$stmt->fetch ();

			
			echo '<textarea rows=10 name="area2" style="width: 740px; background-color: white;">' . mb_convert_encoding(nl2br($contentDescription), 'UTF-8', 'UTF-8') . '</textarea>';
			echo '<input type="Submit" name="Submit" value="Update">';
		}
	}
	
	public function updatecontent()
	{
		$getDescription = filter_input(INPUT_POST, 'area2');
		
		$aboutID = filter_input(INPUT_POST, 'aboutID');
		$serviceID = filter_input(INPUT_POST, 'serviceID');
		
		if ($aboutID)
		{
			$getID = $aboutID;
			$query = "UPDATE about SET aboutDescription=? WHERE aboutID=?";
			
		} elseif ($serviceID)
		{
			$getID = $serviceID;
			$query = "UPDATE services SET serviceDescription=? WHERE serviceID=?";
		}
		
		$stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param('si', $getDescription, $getID);
        
        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=web-settings.php?id=ContentEditor">';
	}
	
}