<?php

$dbConnection = databaseConnection();


class cookbook
{
	#const ModuleDescription = 'Access to add addition Resource Links as well change all Resource information  on pages in a text Editor.';
	#const ModuleAuthor = 'Sunsetcoders Development Team.';
	#const ModuleVersion = '1.0c';
	
	protected $dbConnection;
	
	private $setPostID;
	private $setGetID;
	private $getResourceID;
	private $postResourceID;
	
	
	function __construct($dbConnection)
	{
		global $dbConnection;
		
		$this->dbConnection = $dbConnection;

		$this->setPostID = filter_input(INPUT_POST, 'moduleID');
		$this->setGetID = filter_input(INPUT_GET, 'moduleID');
		
		$this->getResourceID = filter_input(INPUT_GET, 'resourceID');
		$this->postResourceID = filter_input(INPUT_POST, 'resourceID');
	}
	
	public function cookbook()
	{
		echo '<b>Family Cookbook</b> <a href="web-settings.php?id=Cookbook&&moduleID=AddRecipe"><button>Add New</button></a><br><br><br>';
		echo '<table width=100% cellpadding=5 cellspacing=0 border=1>';
		echo '<tr bgcolor=Black><td colspan=2 style="color: white;">Recipe Name</td></tr>';
		$stmt = $this->dbConnection->prepare ( "SELECT cookbookID, cookbookImage, cookbookName FROM cookbook" );
		$stmt->execute ();
		
		$stmt->bind_result ( $cookbookID, $cookbookImage, $cookbookName );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<tr bgcolor=white style="cursor: pointer;"  onclick="location.href=\'web-settings.php?id=Cookbook&&moduleID=EditRecipe&&cookbookID='.$cookbookID.'\'"><td><img src="../Images/cookbook/'.$cookbookImage.'" height=150></td><td width=75%>'.$cookbookName.'</td></tr>';
			 
		}
		echo '</table>';
				
	}
	
	public function uploadResourceFile()
	{
		define("UPLOAD_DIR", "../files/");
		
		if (!empty($_FILES["myFile"])) {
    		$myFile = $_FILES["myFile"];

    		if ($myFile["error"] !== UPLOAD_ERR_OK) {
        		echo "<p>An error occurred.</p>";
        		exit;
    		}

    		// ensure a safe filename
    		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

    		// don't overwrite an existing file
    		$i = 0;
    		$parts = pathinfo($name);
    		while (file_exists(UPLOAD_DIR . $name)) {
        		$i++;
        		$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    		}

    		// preserve file from temporary directory
    		$success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
    		
    		if (!$success) { 
        		echo "<p>Unable to save file.</p>";
        		exit;
    		}

   			 // set proper permissions on the new file
    		chmod(UPLOAD_DIR . $name, 0644);
		}
		echo 'You have successfully added a new File. <br><br><br>Please Wait.....<br>';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Resources">';
		
	}
	
	public function addRecipe()
	{
		echo '<form method="POST" action="?id=CookBook&&moduleID=UploadRecipe" enctype="multipart/form-data">';
		echo '<table border=0 cellpadding=5 cellspacing=0 width=100%>';
		echo '<tr><td colspan=3><b>Add New Recipe</b></td></tr>';
		echo '<tr><td colspan=3></td></tr>';
		echo '<tr><td colspan=2><b>Recipe Name</b></td><td rowspan=18 valign=top><input type="file" name="fileToUpload" id="fileToUpload"></td></tr>';
		echo '<tr><td colspan=2><input type="text" name="cookbookName" size="50"></td></tr>';
		
		echo '<tr><td colspan=2><b>Ingredients</b></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient1" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient2" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient3" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient4" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient5" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient6" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient7" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient8" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient9" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient10" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient11" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient12" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient13" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient14" size="70"></td></tr>';
		echo '<tr><td>Ingredient </td><td><input type="text" name="cookbookIngredient15" size="70"></td></tr>';
		
		echo '<tr><td colspan=3><b>Description</b></td></tr>';
		echo '<tr><td colspan=3><textarea name="cookbookDescription" style="width: 940px; height: 400px; background-color: white;"></textarea></td></tr>';
		echo '<tr><td colspan=3><input type="submit" name="submit" value="Add Recipe"></td></tr>';
		echo '</table>';
	}
	public function uploadRecipe()
	{
		$cookbookName = filter_input ( INPUT_POST, 'cookbookName' );
		
		$cookbookIngredient1 = filter_input ( INPUT_POST, 'cookbookIngredient1' );
		$cookbookIngredient2 = filter_input ( INPUT_POST, 'cookbookIngredient2' );
		$cookbookIngredient3 = filter_input ( INPUT_POST, 'cookbookIngredient3' );
		$cookbookIngredient4 = filter_input ( INPUT_POST, 'cookbookIngredient4' );
		$cookbookIngredient5 = filter_input ( INPUT_POST, 'cookbookIngredient5' );
		$cookbookIngredient6 = filter_input ( INPUT_POST, 'cookbookIngredient6' );
		$cookbookIngredient7 = filter_input ( INPUT_POST, 'cookbookIngredient7' );
		$cookbookIngredient8 = filter_input ( INPUT_POST, 'cookbookIngredient8' );
		$cookbookIngredient9 = filter_input ( INPUT_POST, 'cookbookIngredient9' );
		$cookbookIngredient10 = filter_input ( INPUT_POST, 'cookbookIngredient10' );
		$cookbookIngredient11 = filter_input ( INPUT_POST, 'cookbookIngredient11' );
		$cookbookIngredient12 = filter_input ( INPUT_POST, 'cookbookIngredient12' );
		$cookbookIngredient13 = filter_input ( INPUT_POST, 'cookbookIngredient13' );
		$cookbookIngredient14 = filter_input ( INPUT_POST, 'cookbookIngredient14' );
		$cookbookIngredient15 = filter_input ( INPUT_POST, 'cookbookIngredient15' );
		$cookbookDescription = filter_input ( INPUT_POST, 'cookbookDescription' );		

		$target_dir = "../Images/cookbook/";
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
		
			$cookbookImage =  basename($_FILES["fileToUpload"]["name"]);
			
		$stmt = $this->dbConnection->prepare ( "INSERT INTO cookbook (userID, 
				
				cookbookName,
				cookbookImage,
				cookbookDescription,
				cookbookIngredient1,
				cookbookIngredient2,
				cookbookIngredient3,
				cookbookIngredient4,
				cookbookIngredient5,
				cookbookIngredient6,
				cookbookIngredient7,
				cookbookIngredient8,
				cookbookIngredient9,
				cookbookIngredient10,
				cookbookIngredient11,
				cookbookIngredient12,
				cookbookIngredient13,
				cookbookIngredient14,
				cookbookIngredient15,
				
				
				) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" );
		
		$stmt->bind_param ( 'issssssssssssssssss', $userID, $cookbookName, $cookbookImage, $cookbookDescription, $cookbookIngredient1, $cookbookIngredient2, 
				$cookbookIngredient3, $cookbookIngredient4, $cookbookIngredient5, $cookbookIngredient6, $cookbookIngredient7, $cookbookIngredient8, $cookbookIngredient9,
				$cookbookIngredient10, $cookbookIngredient11, $cookbookIngredient12, $cookbookIngredient13, $cookbookIngredient14, $cookbookIngredient15 );
		
		$status = $stmt->execute ();
		
		echo 'You have successfully added a new Recipe. <br><br><br>Please Wait.....<br>';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Cookbook">';
		
	}
	public function editRecipe()
	{
		$resourceID = filter_input ( INPUT_GET, 'resourceID' );
		?>
		        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
		        <script type="text/javascript">
		            bkLib.onDomLoaded(function () {
		                nicEditors.allTextAreas()
		            });
		        </script>
		
		        <?php
		        
		echo '<table cellpadding=5>';
		echo '<tr><td><h1>Resource Editor</h1></td></tr>';
		echo '<form method="POST" action="web-settings.php?id=Resources&&moduleID=updateResource">';
		echo '<input type="hidden" name="resourceID" value="'.$resourceID.'">';
		
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT resourceID, resourceName, resourceLink FROM resources WHERE resourceID=? " )) {
		
			$stmt->bind_param ( "i", $resourceID );
			$stmt->execute ();
		
			$stmt->bind_result ( $resourceID, $resourceName, $resourceLink );
			$stmt->fetch ();

			echo '<tr><td>&nbsp;</td></tr>';
			echo '<tr><td><b>Hyperlink Name</td><td><b>Hyperlink</td></tr>';
			echo '<tr><td><input type="text" name="resourceName" value="'.$resourceName.'" size=40></td><td><input type="text" name="resourceLink" value="'.$resourceLink.'" size=180></td></tr>';
			echo '<tr><td><input type="Submit" name="Submit" value="Update"></form><a href="web-settings.php?id=Resources&&moduleID=DeleteResource&&resourceID='.$this->getResourceID.'"><button>Delete</button></a></td></tr>';
			echo '</table>';
			echo '</form>';
		}
	}
	
	public function updateRecipe()
	{
		$resourceName = filter_input(INPUT_POST, 'resourceName');
		$resourceLink = filter_input(INPUT_POST, 'resourceLink');
		$cookbookID = filter_input(INPUT_POST, 'cookbookID');
		
		$stmt = $this->dbConnection->prepare("UPDATE cookbook SET resourceName=?, resourceLink=? WHERE cookbookID=?");
        $stmt->bind_param('ssi', $resourceName, $resourceLink, $cookbookID);
        
        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Recipe Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=web-settings.php?id=Cookbook">';
	}
	
	public function deleteRecipe()
	{
		$getID = filter_input(INPUT_GET, 'cookbookID');
	
		$stmt = $this->dbConnection->prepare("DELETE FROM cookbook WHERE cookbookID = ?");
		$stmt->bind_param('i', $getID);
		$stmt->execute();
		$stmt->close();
	
		echo 'You have successfully deleted a Recipe. <br><br><br>Please Wait.....<br>';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Cookbook">';
	}
}