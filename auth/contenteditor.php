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
		echo '<tr><td>&nbsp;</td></tr>';
		echo '<tr><td>CookBook Recipes</td></tr>';
		$stmt = $this->dbConnection->prepare ( "SELECT cookbookID, cookbookName FROM cookbook" );
		$stmt->execute ();
		
		$stmt->bind_result ( $cookbookID, $cookbookName );
		
		while ( $checkRow = $stmt->fetch () ) {
		
			echo '<tr bgcolor=white><td width="100"><a href="web-settings.php?id=Contenteditor&&moduleID=editRecipe&&cookbookID='.$cookbookID.'">'.$cookbookName.'</a></td></tr>';
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
	
	public function updateCookBook()
	{
		$cookbookID = filter_input(INPUT_POST, 'cookbookID');
		$cookbookName = filter_input(INPUT_POST, 'cookbookName');
		
		$cookbookIngredient1 = filter_input(INPUT_POST, 'cookbookIngredient1');
		$cookbookIngredient2 = filter_input(INPUT_POST, 'cookbookIngredient2');
		$cookbookIngredient3 = filter_input(INPUT_POST, 'cookbookIngredient3');
		$cookbookIngredient4 = filter_input(INPUT_POST, 'cookbookIngredient4');
		$cookbookIngredient5 = filter_input(INPUT_POST, 'cookbookIngredient5');
		$cookbookIngredient6 = filter_input(INPUT_POST, 'cookbookIngredient6');
		$cookbookIngredient7 = filter_input(INPUT_POST, 'cookbookIngredient7');
		$cookbookIngredient8 = filter_input(INPUT_POST, 'cookbookIngredient8');
		$cookbookIngredient9 = filter_input(INPUT_POST, 'cookbookIngredient9');
		$cookbookIngredient10 = filter_input(INPUT_POST, 'cookbookIngredient10');
		$cookbookIngredient11 = filter_input(INPUT_POST, 'cookbookIngredient11');
		$cookbookDescription = filter_input(INPUT_POST, 'area2');
		
		if (basename($_FILES["fileToUpload"]["name"]))
		{
		$target_dir = "../Images/CookBook/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry, your file was not uploaded.";
					// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
					} else {
						echo "Sorry, there was an error uploading your file.";
					}
				}
				$cookbookImage = basename( $_FILES["fileToUpload"]["name"]);
				$query = "UPDATE cookbook SET cookbookName=?, cookbookImage=?, cookbookIngredient1=?, cookbookIngredient2=?, cookbookIngredient3=?, cookbookIngredient4=?, cookbookIngredient5=?, cookbookIngredient6=?, cookbookIngredient7=?, cookbookIngredient8=?, cookbookIngredient9=?, cookbookIngredient10=?, cookbookIngredient11=?, cookbookDescription=? WHERE cookbookID=?"; 
				$parm = bind_param('ssssssssssssssi', $cookbookName, $cookbookImage, $cookbookIngredient1, $cookbookIngredient2, $cookbookIngredient3, $cookbookIngredient4, $cookbookIngredient5, $cookbookIngredient6, $cookbookIngredient7, $cookbookIngredient8, $cookbookIngredient9, $cookbookIngredient10, $cookbookIngredient11, $cookbookDescription, $cookbookID);
				
				
		} else 
		{
			$parm = 2;
			$query = "UPDATE cookbook SET cookbookName=?, cookbookIngredient1=?, cookbookIngredient2=?, cookbookIngredient3=?, cookbookIngredient4=?, cookbookIngredient5=?, cookbookIngredient6=?, cookbookIngredient7=?, cookbookIngredient8=?, cookbookIngredient9=?, cookbookIngredient10=?, cookbookIngredient11=?, cookbookDescription=? WHERE cookbookID=?";
			
		}

		$stmt = $this->dbConnection->prepare($query);
        
		if ($parm == 2)
		$stmt->bind_param('sssssssssssssi', $cookbookName, $cookbookIngredient1, $cookbookIngredient2, $cookbookIngredient3, $cookbookIngredient4, $cookbookIngredient5, $cookbookIngredient6, $cookbookIngredient7, $cookbookIngredient8, $cookbookIngredient9, $cookbookIngredient10, $cookbookIngredient11, $cookbookDescription, $cookbookID);
        
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
	
	
	public function editRecipe()
	{
		$cookbookID = filter_input(INPUT_GET, 'cookbookID');
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT cookbookName, cookbookImage, cookbookIngredient1, cookbookIngredient2, cookbookIngredient3, cookbookIngredient4, cookbookIngredient5, cookbookIngredient6, cookbookIngredient7, cookbookIngredient8, cookbookIngredient9, cookbookIngredient10, cookbookIngredient11, cookbookDescription FROM cookbook WHERE cookbookID=? " )) {
				
			$stmt->bind_param ( "i", $cookbookID );
			$stmt->execute ();
			$stmt->bind_result ( $cookbookName, $cookbookImage, $cookbookIngredient1, $cookbookIngredient2, $cookbookIngredient3, $cookbookIngredient4, $cookbookIngredient5, $cookbookIngredient6, $cookbookIngredient7, $cookbookIngredient8, $cookbookIngredient9, $cookbookIngredient10, $cookbookIngredient11, $cookbookDescription );
			$stmt->fetch ();
			
			echo '<form method="POST" action="web-settings.php?id=Contenteditor&&moduleID=UpdateCookbook" enctype="multipart/form-data">';
			echo '<input type="hidden" name="cookbookID" value="'.$cookbookID.'">';
			echo '<table>';
			echo '<tr><td colspan=2><b>Edit Recipe</td><td rowspan=18 valign=top><br><br><br><br><br><br><br><img src="../Images/CookBook/'.$cookbookImage.'"><br><br><br><b>Please Select New Image</b><br><input type="file" name="fileToUpload" id="fileToUpload"></td></tr>';
			echo '<tr><td><b>Recipe Name: </td><td><input type="text" name="cookbookName" value="'.$cookbookName.'" size=80></td></tr>';
			
			echo '<tr><td><br><br>&nbsp;</td></tr>';
			
			echo '<tr><td><b>Ingredient1: </td><td><input type="text" name="cookbookIngredient1" value="'.$cookbookIngredient1.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient2: </td><td><input type="text" name="cookbookIngredient2" value="'.$cookbookIngredient2.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient3: </td><td><input type="text" name="cookbookIngredient3" value="'.$cookbookIngredient3.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient4: </td><td><input type="text" name="cookbookIngredient4" value="'.$cookbookIngredient4.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient5: </td><td><input type="text" name="cookbookIngredient5" value="'.$cookbookIngredient5.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient6: </td><td><input type="text" name="cookbookIngredient6" value="'.$cookbookIngredient6.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient7: </td><td><input type="text" name="cookbookIngredient7" value="'.$cookbookIngredient7.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient8: </td><td><input type="text" name="cookbookIngredient8" value="'.$cookbookIngredient8.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient9: </td><td><input type="text" name="cookbookIngredient9" value="'.$cookbookIngredient9.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient10: </td><td><input type="text" name="cookbookIngredient10" value="'.$cookbookIngredient10.'" size=80></td></tr>';
			echo '<tr><td><b>Ingredient11: </td><td><input type="text" name="cookbookIngredient11" value="'.$cookbookIngredient11.'" size=80></td></tr>';
			
			echo '<tr><td><br><br>&nbsp;</td></tr>';
			
			echo '<tr><td><b>Description: </td></tr>';
			echo '<tr><td colspan=2><textarea rows=10 name="area2" style="width: 740px; background-color: white;">' . nl2br($cookbookDescription) . '</textarea></td></tr>';
			echo '<tr><td><input type="Submit" name="Submit" value="Update"></td></tr>';
			echo '</table>';
			
				

		}
		

		
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