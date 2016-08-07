<?php
require_once ('../auth.php');
echo '<link rel="stylesheet" type="text/css" href="auth.css">';

$dbConnection = databaseConnection ();

$authClass = new authClass ( $dbConnection );
$authClass->landingPage ();

class authClass {

	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	
	function __construct($dbConnection) {
	
		$this->dbConnection = $dbConnection;
		
		$this->setPostID = filter_input ( INPUT_POST, 'id' );
		$this->setGetID = filter_input ( INPUT_GET, 'id' );
		
		if ($this->setGetID == "processLogin") {
			$this->processLogin ();
			exit ();
		}
		
		if (! $this->is_admin ()) {
			$this->loginScreen ();
			exit ();
		}
	}
	private function is_admin() {
		if ($stmt = $this->dbConnection->prepare ( "SELECT userUsername, userPassword FROM users WHERE userUsername=? AND userPassword=? AND userStatus='Administrator' " )) {
			
			$stmt->bind_param ( "ss", $_SESSION ['userUsername'], $_SESSION ['userPassword'] );
			$stmt->execute ();
			
			$stmt->bind_result ( $userUsername, $userPassword );
			$stmt->fetch ();
			
			if ($userUsername == TRUE)
				return TRUE;
		}
	}
	public function loginScreen() {
		echo '<div class="orangeBox"></div>';
		echo '<table width=100% border=0 height=400px;>';
		echo '<tr><td><center><img src="../Images/logo.png" height=100></td></tr>';
		echo '<tr><td><center>';
		
		echo '<form method="post" action="web-settings.php?id=processLogin">';
		echo '<table>';
		echo '<tr><td>Username:</td><td><input type="text" name="setUsername" placeholder="Username"></td></tr>';
		echo '<tr><td>Password:</td><td><input type="password" name="setPassword" placeholder="Password"></td></tr>';
		echo '<tr><td><input type="submit" name="submit" value="Login"></td></tr>';
		echo '<tr><td></td></tr>';
		echo '</table>';
		echo '</form>';
		
		echo '</td></tr>';
		echo '</table>';
	}
	private function processLogin() {
		echo '<table width=100% border=0 height=400px;>';
		echo '<tr><td><center><img src="../Images/logo.png" height=100></td></tr>';
		echo '<tr><td><center>';
		
		$userUsername = filter_input ( INPUT_POST, 'setUsername' );
		$userPassword = filter_input ( INPUT_POST, 'setPassword' );
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT userUsername, userPassword FROM users WHERE userUsername=? AND userPassword=? AND userStatus='Administrator' " )) {
			
			$stmt->bind_param ( "ss", $userUsername, $userPassword );
			$stmt->execute ();
			
			$stmt->bind_result ( $userUsername, $userPassword );
			$stmt->fetch ();
			
			if ($userUsername) {
				$_SESSION ['userUsername'] = $userUsername;
				$_SESSION ['userPassword'] = $userPassword;
				
				echo '<tr><td><center>Access Granted!</td></tr>';
			} else {
				echo '<tr><td><center>Access Denied!</td></tr>';
			}
		}
		echo '<tr><td><center><font color=black><b>Please Wait!!!!</td></tr>';
		
		echo '</td></tr>';
		echo '</table>';
		echo '<meta http-equiv="refresh" content="1;url=web-settings.php">';
	}
	public function landingPage() {
		echo '<table id="full-site">';
		echo '<tr><td class="left-side-bar">';
		
		echo '<table cellspacing=0 cellpadding=5 width=100%>';
		echo '<tr><td><a href="web-settings.php">DashBoard</a></td></tr>';
		echo '<tr><td class="blueBox">';
		
		if ($this->setGetID) {
			echo '<font color=white>Module: <br><br>';
			echo ucfirst ( $this->setGetID ) . '<br>';
		}
		
		echo '</td></tr>';
		
		echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Media">Media</a></td></tr>';
		echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Modules">Modules</a></td></tr>';
		
		$stmt = $this->dbConnection->prepare ( "SELECT settingsName, settingsFilename FROM settings" );
		$stmt->execute ();
		
		$stmt->bind_result ( $settingsName, $settingsFilename );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			$tempValue = explode ( '.', $settingsFilename );
			
			$setModuleName = $tempValue [0];
			
			echo '<tr><td width="100"> - <a class="setPageName" href="web-settings.php?id=' . $setModuleName . '">' . $settingsName . '</a></td></tr>';
		}
		echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Users">Users</a></td></tr>';
		echo '<tr><td class="sidebar-header">Settings</td></tr>';
		
		echo '</table>';
		
		echo '</td><td valign=top>';
		
		echo '<table border=0 cellpadding=15 cellspacing=0 bordercolor=blue width=100%  bgcolor=d8dbe0>';
		echo '<tr><td bgcolor=white align=right> ' . $_SESSION ['userUsername'] . ' <a href="web-settings.php?id=Logout"><button>Logout</button></a></td></tr>';
		echo '<tr><td>';
		
		$this->switchMode ();
		
		echo '</td></tr>';
		echo '</table>';
		
		echo '</td></tr>';
		echo '</table>';
	}
	public function setModuleUse() {
		
		echo '<table width=100% border=0 cellpadding=10>';
		
		echo '<tr><td colspan=2>Modules <a href="web-settings.php?id=AddModule"><button>Add New</button></a> </td></tr>';
		echo '<tr><td>&nbsp;<td></tr>';
		echo '<tr class="userLine"><td width=200><b>Modules</b></td><td width=250><b>Status</b></td></tr>';
		
		if ($handle = opendir ( '.' )) {
			while ( false !== ($entry = readdir ( $handle )) ) {
				if ($entry != "." && $entry != ".." && $entry != "auth.css" && $entry != "Images" && $entry != "web-settings.php" && $entry != "media.php" && $entry != "menu.php") {
					
					$moduleName = ucfirst(substr($entry, 0, -4));
					$lowerCaseModuleName = strtolower ( $entry );
					include_once ($lowerCaseModuleName);
					
					if ($stmt = $this->dbConnection->prepare ( "SELECT settingsFilename FROM settings WHERE settingsFilename=? " )) {
						
						$stmt->bind_param ( "s", $entry );
						$stmt->execute ();
						
						$stmt->bind_result ( $settingsFilename );
						$stmt->fetch ();
						
						if ($settingsFilename) {
							echo '<tr><td class="bottomLine">'.$moduleName.' </td><td class="bottomLine"><a class="activeLink" href="web-settings.php?id=ActivateModule&&moduleName=' . $moduleName . '">Activate</a> <a href="web-settings.php?id=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></td></tr>';
						} else {
							echo '<tr><td class="bottomLine">'.$moduleName.' </td><td class="bottomLine"><a href="web-settings.php?id=ActivateModule&&moduleName=' . $moduleName . '">Activate</a> <a class="activeLink" href="web-settings.php?id=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></td></tr>';
						}
					}
					unset ( $stmt );
				}
			}
			closedir ( $handle );
		}
		
		echo '</table>';
	}
	public function defaultScreen() {
		echo '<table>';
		echo '<tr><td>This is Default</td></tr>';
		echo '</table>';
	}
	private function activeModule() {
		echo 'This is module Activation';
		
		$getModuleName = filter_input ( INPUT_GET, 'moduleName' );
		$getFileName = filter_input ( INPUT_GET, 'moduleName' );
		$setFileName = $getFileName . '.php';
		
		$stmt = $this->dbConnection->prepare ( "INSERT INTO settings (settingsName, settingsFilename) VALUES (?,?)" );
		$stmt->bind_param ( 'ss', $getModuleName, $setFileName );
		
		$status = $stmt->execute ();
		
		echo 'Module Activated... Please Wait!!!';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Modules">';
	}
	private function deactivateModule() {
		
		$getModuleName = filter_input ( INPUT_GET, 'moduleName' );
		
		$stmt = $this->dbConnection->prepare ( "DELETE FROM settings WHERE settingsName=?" );
		$stmt->bind_param ( 's', $getModuleName );
		
		$status = $stmt->execute ();
		echo 'Module Deactivated... Please Wait!!!';
		echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Modules">';
	}
	public function switchMode() {
		
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		$moduleID = filter_input ( INPUT_GET, 'moduleID' );
		$localAction = NULL;
		
		if (isset ( $this->setPostID )) {
			$localAction = $this->setPostID;
		} elseif (isset ( $this->setGetID )) {
			$localAction = urldecode ( $this->setGetID );
		}
		
		$lowerName = strtolower ( $localAction );
		$checkName = strtoupper ( $localAction );
		$lowerModule = strtolower ( $moduleID );
		
		Switch (strtoupper ( $localAction )) {
			
			case "DEACTIVATEMODULE" :
				$this->deactivateModule ();
				break;
			case "ACTIVATEMODULE" :
				$this->activeModule ();
				break;
			case "LOGOUT" :
				session_destroy ();
				header ( "LOCATION:web-settings.php" );
				exit ();
			case "PROCESSLOGIN" :
				$this->processLogin ();
				break;
			case "MODULES" :
				$this->setModuleUse ();
				break;
			case (NULL) :
				$this->defaultScreen ();
				break;
			case ($checkName) :
				include_once ($lowerName . '.php');
				
				if ($moduleID)
				{
					$loadClass = new $lowerName ( $this->dbConnection );
					$loadClass->$lowerModule ();
					
				}elseif (! isset ( $moduleID )) {
					$loadClass = new $checkName ( $this->dbConnection );
					$loadClass->$checkName ();
				}
				break;
		}
	}
}

