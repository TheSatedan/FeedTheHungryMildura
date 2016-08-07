<?php

$dbConnection = databaseConnection();


class faq
{
	#const ModuleDescription = 'Frequently Asked Questions, Shows how to add them, modify and Delete them.';
	#const ModuleAuthor = 'Sunsetcoders Development Team.';
	#const ModuleVersion = '1.0c';
	
	protected $dbConnection;
	
	private $setPostID;
	private $setGetID;
	private $getFaqID;
	private $postFaqID;
	
	
	function __construct($dbConnection)
	{
		global $dbConnection;
		
		$this->dbConnection = $dbConnection;

		$this->setPostID = filter_input(INPUT_POST, 'moduleID');
		$this->setGetID = filter_input(INPUT_GET, 'moduleID');
		
		$this->getFaqID = filter_input(INPUT_GET, 'faqID');
		$this->postFaqID = filter_input(INPUT_POST, 'faqID');
	}
		
	
	
	public function faq()
	{
		echo '<b>Frequently Asked Questions</b> <a href="web-settings.php?id=Faq&&moduleID=AddFaq"><button>Add New</button></a><br><br><br>';
		echo '<table width=100% cellpadding=5 cellspacing=0 border=1>';
		echo '<tr><td>Question</td><td>Answer</td></tr>';
		$stmt = $this->dbConnection->prepare ( "SELECT faqID, faqQuestion, faqAnswer FROM faq ORDER BY faqOrder" );
		$stmt->execute ();
		
		$stmt->bind_result ( $faqID, $faqQuestion, $faqAnswer );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<tr bgcolor=white style="cursor: pointer;"  onclick="location.href=\'web-settings.php?id=Faq&&moduleID=EditFaq&&faqID='.$faqID.'\'"><td width="40%">'.$faqQuestion.'</td><td>'.$faqAnswer.'</td></tr>';
			 
		}
		echo '</table>';
		
	}
	
	public function addFaq()
	{
		echo '<form method="POST" action="web-settings.php?id=Faq&&moduleID=UploadFaq">';
		echo '<table border=0 cellpadding=5 cellspacing=5>';
		echo '<tr><td colspan=2><b>Add Frequently Asked Question</b></td></tr>';
		echo '<tr><td colspan=2></td></tr>';
		echo '<tr><td><b>Question</b></td><td><b>Answer</b></td></tr>';
		echo '<tr><td><input type="text" name="newQuestion" size="100"></td><td><input type="text" name="newAnswer" size="100"></td></tr>';
		echo '<tr><td colspan=2><input type="submit" name="submit" value="Add New"></td></tr>';
		echo '</table>';
	}
	public function uploadFaq()
	{
		$newQuestion = filter_input ( INPUT_POST, 'newQuestion' );
		$newAnswer = filter_input ( INPUT_POST, 'newAnswer' );
		$newOrder = 1;

		$stmt = $this->dbConnection->prepare ( "INSERT INTO faq (faqQuestion, faqAnswer, faqOrder) VALUES (?,?,?)" );
		
		$stmt->bind_param ( 'ssi', $newQuestion, $newAnswer, $newOrder );
		
		$status = $stmt->execute ();
		
		echo 'You have successfully added a new Frequently Asked Question. <br><br><br>Please Wait.....<br>';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Faq">';
		
	}
	public function editFaq()
	{
		$faqID = filter_input ( INPUT_GET, 'faqID' );
		?>
		<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
		<script type="text/javascript"> bkLib.onDomLoaded(function () { nicEditors.allTextAreas() }); </script>
		
		<?php
		
		echo '<table cellpadding=5>';
		echo '<tr><td><h1>Question Editor</h1></td></tr>';
		echo '<form method="POST" action="web-settings.php?id=Faq&&moduleID=updateFaq">';
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT faqID, faqQuestion, faqAnswer, faqOrder FROM faq WHERE faqID=? " )) {
		
			$stmt->bind_param ( "i", $faqID );
			$stmt->execute ();
		
			$stmt->bind_result ( $faqID, $faqQuestion, $faqAnswer, $faqOrder );
			$stmt->fetch ();
			
			echo '<input type="hidden" name="faqID" value="'.$faqID.'">';
			echo '<tr><td>&nbsp;</td></tr>';
			echo '<tr><td><b>Question</td><td><b>Answer</td></tr>';
			echo '<tr><td><input type="text" name="newQuestion" value="'.$faqQuestion.'" size=100></td><td><input type="text" name="newAnswer" value="'.$faqAnswer.'" size=100></td></tr>';
			echo '<tr><td><input type="Submit" name="Submit" value="Update"></form><a href="web-settings.php?id=Faq&&moduleID=DeleteFaq&&faqID='.$faqID.'"><button>Delete</button></a></td></tr>';
			echo '</table>';
			echo '</form>';
		}
	}
	
	public function deleteFaq()
	{
		$getID = filter_input(INPUT_GET, 'faqID');
		
		$stmt = $this->dbConnection->prepare("DELETE FROM faq WHERE faqID = ?");
		$stmt->bind_param('i', $getID);
		$stmt->execute();
		$stmt->close();
		
		echo 'You have successfully Delete a Frequently Asked Question. <br><br><br>Please Wait.....<br>';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Faq">';
	}
	
	public function updateFaq()
	{
		$getQuestion = filter_input(INPUT_POST, 'newQuestion');
		$getAnswer = filter_input(INPUT_POST, 'newAnswer');
		$getID = filter_input(INPUT_POST, 'faqID');
		
		$stmt = $this->dbConnection->prepare("UPDATE faq SET faqQuestion=?, faqAnswer=? WHERE faqID=?");
        $stmt->bind_param('ssi', $getQuestion, $getAnswer, $getID);
        
        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Question Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=web-settings.php?id=Faq">';
	}
	
}