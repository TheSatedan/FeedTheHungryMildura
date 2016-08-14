<?php

require_once ('../auth.php');


echo '<link rel="stylesheet" type="text/css" href="auth.css">';

$dbConnection = databaseConnection();

$authClass = new authClass($dbConnection);
$authClass->landingPage();

class authClass {

    protected $dbConnection;
    private $setPostID;
    private $setGetID;

    function __construct($dbConnection) {

        $this->dbConnection = $dbConnection;

        $this->setPostID = filter_input(INPUT_POST, 'id');
        $this->setGetID = filter_input(INPUT_GET, 'id');

        if ($this->setGetID == "processLogin") {
            $this->processLogin();
            exit();
        }

        if (!$this->is_admin()) {
            $this->loginScreen();
            exit();
        }
    }

    private function is_admin() {
        
        if ($stmt = $this->dbConnection->prepare("SELECT userUsername, userPassword FROM users WHERE userUsername=? AND userPassword=? AND userStatus='Administrator' ")) {

            $stmt->bind_param("ss", $_SESSION ['userUsername'], $_SESSION ['userPassword']);
            $stmt->execute();

            $stmt->bind_result($userUsername, $userPassword);
            $stmt->fetch();

            if ($userUsername == TRUE)
                return TRUE;
        }
    }

    public function loginScreen() {

        echo '<center><table width=1024 height=400px;>';
        echo '<tr><td><br></td></tr>';
        echo '<tr><td><img src="Images/logo.png"></td></tr>';
        echo '<tr><td><br><br>&nbsp;<center>';

        echo '<form method="post" action="?id=processLogin">';
        echo '<table width=450 cellpadding=10 style="border-radius: 5px; border: 3px solid #615f5e;">';

        echo '<tr><td align=right style="color: #615f5e;"><b>USER NAME</td><td colspan=2 style="padding-right: 50px;"><center><input type="text" name="setUsername" placeholder="enter your username..." size=25></td></tr>';
        echo '<tr><td align=right style="color: #615f5e;"><b>PASSWORD</td><td colspan=2 style="padding-right: 50px;"><center><input type="password" name="setPassword" placeholder="****" size=25></td></tr>';
        echo '<tr><td ></td><td colspan=2 style="padding-right: 50px;"><center><input id="quoteSubmit" type="image" src="Images/login.png" alt="" onmouseover="javascript:this.src=\'Images/login-over.png\'" onmouseout="javascript:this.src=\'Images/login.png\'"/></td></tr>';
        echo '<tr><td colspan=3></td></tr>';
        echo '<tr><td colspan=2 align=right ><font style="font-weight:bold;  color: #615f5e;">Forgetten your password or username?</td><td width=85 style="padding-right: 50px;"><a href="?id=Recover"><img src="Images/recover.png"></a></td></tr>';
        echo '</table>';
        echo '</form>';


        echo '</td></tr>';
        echo '</table>';
    }

    private function processLogin() {
        
        echo '<table width=100% border=0 height=400px;>';
        echo '<tr><td><center><img src="../Images/logo.png" height=100></td></tr>';
        echo '<tr><td><center>';

        $userUsername = filter_input(INPUT_POST, 'setUsername');
        $userPassword = filter_input(INPUT_POST, 'setPassword');

        if ($stmt = $this->dbConnection->prepare("SELECT userID, userUsername, userPassword FROM users WHERE userUsername=? AND userPassword=? AND userStatus='Administrator' ")) {

            $stmt->bind_param("ss", $userUsername, $userPassword);
            $stmt->execute();

            $stmt->bind_result($userID, $userUsername, $userPassword);
            $stmt->fetch();

            if ($userUsername) {
                $_SESSION ['userUsername'] = $userUsername;
                $_SESSION ['userPassword'] = $userPassword;
                $_SESSION ['userID'] = $userID;

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
        echo '<tr><td><a href="web-settings.php"><img src="Images/logo.png" width=175></a></td></tr>';

        echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Media">Media</a></td></tr>';
        echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Modules">Modules</a></td></tr>';

        $stmt = $this->dbConnection->prepare("SELECT settingsName, settingsFilename FROM settings");
        $stmt->execute();

        $stmt->bind_result($settingsName, $settingsFilename);

        while ($checkRow = $stmt->fetch()) {

            $tempValue = explode('.', $settingsFilename);

            $setModuleName = $tempValue [0];

            echo '<tr><td width="100"> - <a class="setPageName" href="web-settings.php?id=' . $setModuleName . '">' . $settingsName . '</a></td></tr>';
        }
        echo '<tr><td class="sidebar-header"><a class="setPageName" href="web-settings.php?id=Users">Users</a></td></tr>';
        echo '<tr><td class="sidebar-header"><a class="setPageName" href="#">Settings</td></tr>';

        echo '</table>';

        echo '</td><td valign=top>';

        echo '<table border=0 cellpadding=15 cellspacing=0 bordercolor=blue width=100%  bgcolor=d8dbe0>';
        echo '<tr><td bgcolor=white align=right> ' . $_SESSION ['userUsername'] . ' <a href="web-settings.php?id=Logout"><button>Logout</button></a></td></tr>';
        echo '<tr><td>';

        $this->switchMode();

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

        if ($handle = opendir('.')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "auth.css" && $entry != "error_log" && $entry != "Images" && $entry != "web-settings.php" && $entry != "media.php" && $entry != "menu.php") {

                    $moduleName = ucfirst(substr($entry, 0, -4));
                    $lowerCaseModuleName = strtolower($entry);
                    include_once ($lowerCaseModuleName);

                    if ($stmt = $this->dbConnection->prepare("SELECT settingsFilename FROM settings WHERE settingsFilename=? ")) {

                        $stmt->bind_param("s", $entry);
                        $stmt->execute();

                        $stmt->bind_result($settingsFilename);
                        $stmt->fetch();

                        if ($settingsFilename) {
                            echo '<tr><td class="bottomLine">' . $moduleName . ' </td><td class="bottomLine"><a class="activeLink" href="web-settings.php?id=ActivateModule&&moduleName=' . $moduleName . '">Activate</a> <a class="deactiveLink" href="web-settings.php?id=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></td></tr>';
                        } else {
                            echo '<tr><td class="bottomLine">' . $moduleName . ' </td><td class="bottomLine"><a class="deactiveLink" href="web-settings.php?id=ActivateModule&&moduleName=' . $moduleName . '">Activate</a> <a class="activeLink" href="web-settings.php?id=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></td></tr>';
                        }
                    } else {
                        echo '<tr><td class="bottomLine">' . $moduleName . ' </td><td class="bottomLine"><a class="deactiveLink" href="web-settings.php?id=ActivateModule&&moduleName=' . $moduleName . '">Activate</a> <a class="activeLink" href="web-settings.php?id=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></td></tr>';
                    }
                    unset($settingsFilename);
                }
            }
            closedir($handle);
        }

        echo '</table>';
    }

    public function defaultScreen() {
        
        echo '<table width=100% border=1 height=500px>';
        echo '<tr><td valign=top width=25%>Messages';
        
        echo '<table>';
                $stmt = $this->dbConnection->prepare("SELECT messageID, messageFrom, messageDate FROM messages ORDER BY messageDate");
        $stmt->execute();

        $stmt->bind_result($messageID, $messageFrom, $messageDate);

        while ($checkRow = $stmt->fetch()) {

            echo '<tr><td width="300"> - <a href="web-settings.php?id=Messages&&messageID=' . $messageID . '">'.datChange($messageDate).' :: ' . $messageFrom . '  </a></td></tr>';
        }
        echo '</table>';
        
        echo '</td><td valign=top width=25%>New Users';
        
                echo '<table>';
                $stmt = $this->dbConnection->prepare("SELECT userID, userFullName, userJoined FROM users ORDER BY userJoined, userFullName");
        $stmt->execute();

        $stmt->bind_result($userID, $userFullName, $userJoined);

        while ($checkRow = $stmt->fetch()) {

            echo '<tr><td width="300"> - <a href="web-settings.php?id=Users&&moduleID=showUser&&userID=' . $userID . '">'.datChange($userJoined).' :: ' . $userFullName . '  </a></td></tr>';
        }
        echo '</table>';
        
                echo '</td><td valign=top width=25%>HelpLine</td><td>WebStats</td></tr>';
        echo '<tr><td>Requested Pickups</td><td></td></tr>';
        echo '</table>';
    }

    private function activeModule() {


        $getModuleName = filter_input(INPUT_GET, 'moduleName');
        $getFileName = filter_input(INPUT_GET, 'moduleName');
        $setFileName = $getFileName . '.php';

        $stmt = $this->dbConnection->prepare("INSERT INTO settings (settingsName, settingsFilename) VALUES (?,?)");
        $stmt->bind_param('ss', $getModuleName, $setFileName);

        $status = $stmt->execute();

        echo 'Module Activated... Please Wait!!!';
        echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Modules">';
    }

    private function deactivateModule() {

        $getModuleName = filter_input(INPUT_GET, 'moduleName');

        $stmt = $this->dbConnection->prepare("DELETE FROM settings WHERE settingsName=?");
        $stmt->bind_param('s', $getModuleName);

        $status = $stmt->execute();
        echo 'Module Deactivated... Please Wait!!!';
        echo '<meta http-equiv="refresh" content="3;url=web-settings.php?id=Modules">';
    }

    public function switchMode() {

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $moduleID = filter_input(INPUT_GET, 'moduleID');
        $localAction = NULL;

        if (isset($this->setPostID)) {
            $localAction = $this->setPostID;
        } elseif (isset($this->setGetID)) {
            $localAction = urldecode($this->setGetID);
        }

        $lowerName = strtolower($localAction);
        $checkName = strtoupper($localAction);
        $lowerModule = strtolower($moduleID);

        Switch (strtoupper($localAction)) {

            case "DEACTIVATEMODULE" :
                $this->deactivateModule();
                break;
            case "ACTIVATEMODULE" :
                $this->activeModule();
                break;
            case "LOGOUT" :
                session_destroy();
                header("LOCATION:web-settings.php");
                exit();
            case "PROCESSLOGIN" :
                $this->processLogin();
                break;
            case "MODULES" :
                $this->setModuleUse();
                break;
            case (NULL) :
                $this->defaultScreen();
                break;
            case ($checkName) :
                include_once ($lowerName . '.php');

                if ($moduleID) {
                    $loadClass = new $lowerName($this->dbConnection);
                    $loadClass->$lowerModule();
                } elseif (!isset($moduleID)) {
                    $loadClass = new $checkName($this->dbConnection);
                    $loadClass->$checkName();
                }
                break;
        }
    }

}
